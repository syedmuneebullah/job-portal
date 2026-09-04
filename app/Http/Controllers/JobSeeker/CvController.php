<?php
// app/Http/Controllers/JobSeeker/CVController.php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\CvTemplate;
use App\Models\Resume;
use Barryvdh\DomPDF\Facade\Pdf;

class CVController extends Controller
{
    public function builder()
    {
        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates'
        ])->find(Auth::id());

        $templates = CvTemplate::where('is_active', true)->get();
        $savedCVs = Resume::where('user_id', Auth::id())
            ->with('template')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('jobseeker.pages.cv-builder', compact('user', 'templates', 'savedCVs'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:cv_templates,id',
        ]);

        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates'
        ])->find(Auth::id());

        $template = CvTemplate::findOrFail($request->template_id);
        $cvData = $this->prepareCVData($user);
        
        // Debug: Log template details
        \Log::info('Preview Template', [
            'id' => $template->id,
            'name' => $template->name,
            'layout_type' => $template->layout_type,
            'layout_view' => $template->layout_view,
        ]);
        
        $renderedCV = $template->render($cvData);

        return response()->json([
            'success' => true,
            'html' => $renderedCV,
            'template_name' => $template->name,
            'debug' => [
                'layout_type' => $template->layout_type,
                'layout_view' => $template->layout_view,
            ]
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:cv_templates,id',
            'format' => 'nullable|in:pdf,html',
        ]);

        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates'
        ])->find(Auth::id());

        $template = CvTemplate::findOrFail($request->template_id);
        $cvData = $this->prepareCVData($user);
        
        // Debug: Log template details
        \Log::info('Download Template', [
            'id' => $template->id,
            'name' => $template->name,
            'layout_type' => $template->layout_type,
            'layout_view' => $template->layout_view,
        ]);
        
        // Render the template with CV data
        $html = $template->render($cvData);

        
        // Debug: Check HTML length
        \Log::info('Rendered HTML length: ' . strlen($html));

        // $cv = Resume::find($request->cv_id);

        // Create CV record
        $cv = Resume::create([
            'user_id' => Auth::id(),
            'cv_template_id' => $template->id,
            'content' => $cvData,
            'title' => $user->first_name . ' ' . $user->last_name . ' - CV',
            'status' => 'completed',
            'version' => 1,
            'last_generated_at' => now(),
            'is_active' => true,
            'is_primary' => false,
        ]);

        $template->incrementUsage();
        
        $format = $request->format ?? 'pdf';

        if ($format === 'pdf') {
            try {
                // Use the template's rendered HTML for PDF
                $pdfHtml = $this->preparePDFHtml($html);

                
                $pdf = Pdf::loadHTML($pdfHtml);

                $pdf->setPaper('A4', 'portrait');
                $pdf->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                    'isPhpEnabled' => false,
                ]);

                
                $filename = strtolower($user->first_name . '_' . $user->last_name . '_CV.pdf');
                $path = 'cvs/' . $filename;
                
                Storage::disk('public')->put($path, $pdf->output());
                
                $cv->update([
                    'file_path' => $path,
                    'original_name' => $filename,
                    'file_size' => Storage::disk('public')->size($path),
                    'mime_type' => 'application/pdf',
                ]);
                $template->incrementDownloads();

                return $pdf->download($filename);
                
            } catch (\Exception $e) {
                \Log::error('PDF Generation Error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                
                return response()->json([
                    'success' => false,
                    'message' => 'PDF generation failed: ' . $e->getMessage(),
                    'html' => $html,
                    'cv_id' => $cv->id
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'cv_id' => $cv->id
        ]);
    }


/**
 * Prepare HTML for PDF - Simple table-based layout for better PDF support
 */
private function preparePDFHtml($html)
{
    // Extract body content from rendered template
    preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches);
    $bodyContent = $matches[1] ?? $html;
    
    // Convert the HTML to PDF-friendly version
    $pdfHtml = $this->convertToPDFFriendlyHTML($bodyContent);
    
    return $pdfHtml;
}

/**
 * Convert to PDF-friendly HTML (Table-based layout)
 */
private function convertToPDFFriendlyHTML($html)
{
    // Extract data from the rendered HTML
    $data = $this->extractDataFromHTML($html);
    
    // Build PDF-friendly HTML
    $pdfStyles = '
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 12px; 
            line-height: 1.5; 
            color: #333;
            padding: 10px;
            margin: 0;
            background: #fff;
        }
        .cv-pdf {
            max-width: 100%;
            margin: 0 auto;
            border: 1px solid #ddd;
        }
        .sidebar-pdf {
            background: #1a237e;
            color: #fff;
            padding: 20px;
            width: 30%;
            vertical-align: top;
        }
        .main-pdf {
            padding: 20px;
            width: 70%;
            vertical-align: top;
        }
        .profile-photo-pdf {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 3px solid #fff;
        }
        .profile-photo-pdf img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .name-pdf {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            color: #fff;
        }
        .title-pdf {
            font-size: 14px;
            text-align: center;
            opacity: 0.9;
            margin-bottom: 15px;
            color: #fff;
        }
        .contact-pdf p {
            font-size: 11px;
            margin: 5px 0;
            color: #fff;
        }
        .section-title-pdf {
            font-size: 14px;
            font-weight: bold;
            color: #1a237e;
            border-bottom: 2px solid #e8eaf6;
            padding-bottom: 5px;
            margin: 15px 0 10px 0;
        }
        .section-title-pdf-white {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 5px;
            margin: 15px 0 10px 0;
        }
        .skill-item-pdf {
            margin-bottom: 6px;
        }
        .skill-item-pdf span {
            font-size: 11px;
        }
        .skill-bar-pdf {
            width: 100%;
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 2px;
        }
        .skill-progress-pdf {
            height: 100%;
            background: #fff;
            border-radius: 2px;
        }
        .exp-item-pdf, .edu-item-pdf, .cert-item-pdf {
            margin-bottom: 12px;
        }
        .exp-header-pdf, .edu-header-pdf {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }
        .exp-header-pdf h4, .edu-header-pdf h4 {
            font-size: 13px;
            font-weight: 600;
            margin: 0;
        }
        .company-pdf, .institution-pdf {
            font-size: 11px;
            color: #666;
            margin: 2px 0 5px 0;
        }
        .period-pdf {
            font-size: 10px;
            color: #999;
        }
        .desc-pdf {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        ul {
            padding-left: 18px;
            margin: 3px 0;
        }
        ul li {
            font-size: 11px;
            line-height: 1.5;
        }
        .lang-item-pdf, .interest-item-pdf {
            font-size: 11px;
            padding: 3px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .page-break {
            page-break-after: always;
        }
        @media print {
            .sidebar-pdf { background: #1a237e !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .skill-progress-pdf { background: #fff !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .profile-photo-pdf { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
    ';
    
    // Build the PDF HTML
    $pdfHtml = '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Curriculum Vitae</title>
        ' . $pdfStyles . '
    </head>
    <body>
        <div class="cv-pdf">
            <table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                    <!-- Sidebar -->
                    <td class="sidebar-pdf" style="background:#1a237e;color:#fff;padding:20px;width:30%;vertical-align:top;">
                        <!-- Profile Photo -->
                        <div style="text-align:center;">
                            <div class="profile-photo-pdf" style="width:120px;height:120px;border-radius:50%;overflow:hidden;margin:0 auto 15px;border:3px solid #fff;">
                                ' . ($data['profile_photo'] ? '<img src="' . $data['profile_photo'] . '" alt="Photo" style="width:100%;height:100%;object-fit:cover;">' : '<div style="width:100%;height:100%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:30px;">' . substr($data['full_name'] ?? 'JD', 0, 1) . '</div>') . '
                            </div>
                            <h1 style="font-size:22px;font-weight:bold;text-align:center;color:#fff;margin:0;">' . htmlspecialchars($data['full_name'] ?? 'John Doe') . '</h1>
                            <h2 style="font-size:14px;text-align:center;opacity:0.9;margin:5px 0 15px;color:#fff;">' . htmlspecialchars($data['title'] ?? 'Professional') . '</h2>
                        </div>
                        
                        <!-- Contact -->
                        <div style="margin-top:15px;">
                            <div class="section-title-pdf-white" style="font-size:14px;font-weight:bold;color:#fff;border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:5px;margin:15px 0 10px;">Contact</div>
                            <div style="font-size:11px;color:#fff;">
                                <p style="margin:5px 0;">📧 ' . htmlspecialchars($data['email'] ?? '') . '</p>
                                <p style="margin:5px 0;">📱 ' . htmlspecialchars($data['phone'] ?? '') . '</p>
                                <p style="margin:5px 0;">📍 ' . htmlspecialchars($data['location'] ?? '') . '</p>
                            </div>
                        </div>
                        
                        <!-- Skills -->
                        ' . (!empty($data['skills']) ? '
                        <div>
                            <div class="section-title-pdf-white" style="font-size:14px;font-weight:bold;color:#fff;border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:5px;margin:15px 0 10px;">Skills</div>
                            ' . implode('', array_map(function($skill) {
                                return '<div class="skill-item-pdf" style="margin-bottom:6px;">
                                    <span style="font-size:11px;color:#fff;">' . htmlspecialchars($skill) . '</span>
                                    <div class="skill-bar-pdf" style="width:100%;height:4px;background:rgba(255,255,255,0.2);border-radius:2px;overflow:hidden;margin-top:2px;">
                                        <div class="skill-progress-pdf" style="height:100%;background:#fff;border-radius:2px;width:85%;"></div>
                                    </div>
                                </div>';
                            }, $data['skills'])) . '
                        </div>
                        ' : '') . '
                        
                        <!-- Languages -->
                        ' . (!empty($data['languages']) ? '
                        <div>
                            <div class="section-title-pdf-white" style="font-size:14px;font-weight:bold;color:#fff;border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:5px;margin:15px 0 10px;">Languages</div>
                            ' . implode('', array_map(function($lang) {
                                return '<div class="lang-item-pdf" style="font-size:11px;padding:3px 0;border-bottom:1px solid rgba(255,255,255,0.1);color:#fff;">' . htmlspecialchars($lang) . '</div>';
                            }, $data['languages'])) . '
                        </div>
                        ' : '') . '
                        
                        <!-- Interests -->
                        ' . (!empty($data['interests']) ? '
                        <div>
                            <div class="section-title-pdf-white" style="font-size:14px;font-weight:bold;color:#fff;border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:5px;margin:15px 0 10px;">Interests</div>
                            ' . implode('', array_map(function($interest) {
                                return '<div class="interest-item-pdf" style="font-size:11px;padding:3px 0;border-bottom:1px solid rgba(255,255,255,0.1);color:#fff;">' . htmlspecialchars($interest) . '</div>';
                            }, $data['interests'])) . '
                        </div>
                        ' : '') . '
                    </td>
                    
                    <!-- Main Content -->
                    <td class="main-pdf" style="padding:20px;width:70%;vertical-align:top;">
                        <!-- Summary -->
                        ' . (!empty($data['summary']) ? '
                        <div>
                            <div class="section-title-pdf" style="font-size:14px;font-weight:bold;color:#1a237e;border-bottom:2px solid #e8eaf6;padding-bottom:5px;margin:0 0 10px;">Professional Summary</div>
                            <p style="font-size:12px;line-height:1.6;color:#333;margin:0 0 15px;">' . nl2br(htmlspecialchars($data['summary'])) . '</p>
                        </div>
                        ' : '') . '
                        
                        <!-- Experience -->
                        ' . (!empty($data['experience']) ? '
                        <div>
                            <div class="section-title-pdf" style="font-size:14px;font-weight:bold;color:#1a237e;border-bottom:2px solid #e8eaf6;padding-bottom:5px;margin:15px 0 10px;">Work Experience</div>
                            ' . implode('', array_map(function($exp) {
                                $html = '<div class="exp-item-pdf" style="margin-bottom:12px;">';
                                $html .= '<div class="exp-header-pdf" style="display:flex;justify-content:space-between;align-items:baseline;">';
                                $html .= '<h4 style="font-size:13px;font-weight:600;margin:0;">' . htmlspecialchars($exp['title'] ?? '') . '</h4>';
                                $html .= '<span class="period-pdf" style="font-size:10px;color:#999;">' . htmlspecialchars($exp['period'] ?? '') . '</span>';
                                $html .= '</div>';
                                $html .= '<div class="company-pdf" style="font-size:11px;color:#666;margin:2px 0 5px;">' . htmlspecialchars($exp['company'] ?? '') . '</div>';
                                if (!empty($exp['responsibilities'])) {
                                    $html .= '<ul style="padding-left:18px;margin:3px 0;">';
                                    foreach ($exp['responsibilities'] as $resp) {
                                        if (!empty($resp)) {
                                            $html .= '<li style="font-size:11px;line-height:1.5;">' . htmlspecialchars($resp) . '</li>';
                                        }
                                    }
                                    $html .= '</ul>';
                                }
                                $html .= '</div>';
                                return $html;
                            }, $data['experience'])) . '
                        </div>
                        ' : '') . '
                        
                        <!-- Education -->
                        ' . (!empty($data['education']) ? '
                        <div>
                            <div class="section-title-pdf" style="font-size:14px;font-weight:bold;color:#1a237e;border-bottom:2px solid #e8eaf6;padding-bottom:5px;margin:15px 0 10px;">Education</div>
                            ' . implode('', array_map(function($edu) {
                                $html = '<div class="edu-item-pdf" style="margin-bottom:12px;">';
                                $html .= '<div class="edu-header-pdf" style="display:flex;justify-content:space-between;align-items:baseline;">';
                                $html .= '<h4 style="font-size:13px;font-weight:600;margin:0;">' . htmlspecialchars($edu['degree'] ?? '') . '</h4>';
                                $html .= '<span class="period-pdf" style="font-size:10px;color:#999;">' . htmlspecialchars($edu['period'] ?? '') . '</span>';
                                $html .= '</div>';
                                $html .= '<div class="institution-pdf" style="font-size:11px;color:#666;margin:2px 0 5px;">' . htmlspecialchars($edu['institution'] ?? '') . '</div>';
                                if (!empty($edu['gpa'])) {
                                    $html .= '<div style="font-size:10px;color:#666;">GPA: ' . htmlspecialchars($edu['gpa']) . '</div>';
                                }
                                $html .= '</div>';
                                return $html;
                            }, $data['education'])) . '
                        </div>
                        ' : '') . '
                        
                        <!-- Certifications -->
                        ' . (!empty($data['certifications']) ? '
                        <div>
                            <div class="section-title-pdf" style="font-size:14px;font-weight:bold;color:#1a237e;border-bottom:2px solid #e8eaf6;padding-bottom:5px;margin:15px 0 10px;">Certifications</div>
                            ' . implode('', array_map(function($cert) {
                                $html = '<div class="cert-item-pdf" style="margin-bottom:12px;">';
                                $html .= '<div style="display:flex;justify-content:space-between;align-items:baseline;">';
                                $html .= '<h4 style="font-size:13px;font-weight:600;margin:0;">' . htmlspecialchars($cert['name'] ?? '') . '</h4>';
                                $html .= '<span class="period-pdf" style="font-size:10px;color:#999;">' . htmlspecialchars($cert['period'] ?? '') . '</span>';
                                $html .= '</div>';
                                $html .= '<div style="font-size:11px;color:#666;margin:2px 0 5px;">' . htmlspecialchars($cert['institution'] ?? '') . '</div>';
                                $html .= '</div>';
                                return $html;
                            }, $data['certifications'])) . '
                        </div>
                        ' : '') . '
                    </td>
                </tr>
            </table>
        </div>
    </body>
    </html>';
    
    return $pdfHtml;
}

/**
 * Extract data from rendered HTML
 */
private function extractDataFromHTML($html)
{
    $data = [
        'full_name' => '',
        'title' => '',
        'email' => '',
        'phone' => '',
        'location' => '',
        'profile_photo' => '',
        'summary' => '',
        'skills' => [],
        'languages' => [],
        'interests' => [],
        'experience' => [],
        'education' => [],
        'certifications' => [],
    ];
    
    // Extract name
    if (preg_match('/<h1 class="name">(.*?)<\/h1>/', $html, $match)) {
        $data['full_name'] = trim($match[1]);
    }
    
    // Extract title
    if (preg_match('/<h2 class="title">(.*?)<\/h2>/', $html, $match)) {
        $data['title'] = trim($match[1]);
    }
    
    // Extract email
    if (preg_match('/📧\s*(.*?)(?:<|$)/', $html, $match)) {
        $data['email'] = trim($match[1]);
    }
    
    // Extract phone
    if (preg_match('/📱\s*(.*?)(?:<|$)/', $html, $match)) {
        $data['phone'] = trim($match[1]);
    }
    
    // Extract location
    if (preg_match('/📍\s*(.*?)(?:<|$)/', $html, $match)) {
        $data['location'] = trim($match[1]);
    }
    
    // Extract profile photo
    if (preg_match('/<img src="([^"]+)" alt="Profile Photo"/', $html, $match)) {
        $data['profile_photo'] = trim($match[1]);
    }
    
    // Extract summary
    if (preg_match('/<div class="summary-section">.*?<p>(.*?)<\/p>/s', $html, $match)) {
        $data['summary'] = trim(strip_tags($match[1]));
    }
    
    // Extract skills
    if (preg_match_all('/<div class="skill-item">.*?<span>(.*?)<\/span>.*?<\/div>/s', $html, $matches)) {
        foreach ($matches[1] as $skill) {
            $data['skills'][] = trim($skill);
        }
    }
    
    // Extract languages
    if (preg_match_all('/<div class="languages-list">(.*?)<\/div>/s', $html, $match)) {
        if (preg_match_all('/<p>(.*?)<\/p>/', $match[1][0] ?? '', $langMatches)) {
            foreach ($langMatches[1] as $lang) {
                $data['languages'][] = trim($lang);
            }
        }
    }
    
    // Extract interests
    if (preg_match_all('/<div class="interests-list">(.*?)<\/div>/s', $html, $match)) {
        if (preg_match_all('/<p>(.*?)<\/p>/', $match[1][0] ?? '', $interestMatches)) {
            foreach ($interestMatches[1] as $interest) {
                $data['interests'][] = trim($interest);
            }
        }
    }
    
    // Extract experience
    if (preg_match_all('/<div class="experience-item">(.*?)<\/div>\s*<\/div>/s', $html, $expMatches)) {
        foreach ($expMatches[1] as $expHtml) {
            $exp = [];
            if (preg_match('/<h4>(.*?)<\/h4>/', $expHtml, $match)) {
                $exp['title'] = trim($match[1]);
            }
            if (preg_match('/<span>(.*?)<\/span>/', $expHtml, $match)) {
                $exp['period'] = trim($match[1]);
            }
            if (preg_match('/<p class="company">(.*?)<\/p>/', $expHtml, $match)) {
                $exp['company'] = trim($match[1]);
            }
            if (preg_match_all('/<li>(.*?)<\/li>/', $expHtml, $respMatches)) {
                $exp['responsibilities'] = array_map('trim', $respMatches[1]);
            }
            $data['experience'][] = $exp;
        }
    }
    
    // Extract education
    if (preg_match_all('/<div class="education-item">(.*?)<\/div>\s*<\/div>/s', $html, $eduMatches)) {
        foreach ($eduMatches[1] as $eduHtml) {
            $edu = [];
            if (preg_match('/<h4>(.*?)<\/h4>/', $eduHtml, $match)) {
                $edu['degree'] = trim($match[1]);
            }
            if (preg_match('/<span>(.*?)<\/span>/', $eduHtml, $match)) {
                $edu['period'] = trim($match[1]);
            }
            if (preg_match('/<p class="institution">(.*?)<\/p>/', $eduHtml, $match)) {
                $edu['institution'] = trim($match[1]);
            }
            if (preg_match('/GPA:\s*(.*?)(?:<|$)/', $eduHtml, $match)) {
                $edu['gpa'] = trim($match[1]);
            }
            $data['education'][] = $edu;
        }
    }
    
    // Extract certifications
    if (preg_match_all('/<div class="certification-item">(.*?)<\/div>\s*<\/div>/s', $html, $certMatches)) {
        foreach ($certMatches[1] as $certHtml) {
            $cert = [];
            if (preg_match('/<h4>(.*?)<\/h4>/', $certHtml, $match)) {
                $cert['name'] = trim($match[1]);
            }
            if (preg_match('/<span class="period">(.*?)<\/span>/', $certHtml, $match)) {
                $cert['period'] = trim($match[1]);
            }
            if (preg_match('/<p class="institution">(.*?)<\/p>/', $certHtml, $match)) {
                $cert['institution'] = trim($match[1]);
            }
            $data['certifications'][] = $cert;
        }
    }
    
    return $data;
}

    /**
     * Download CV as HTML (Fallback)
     */
    public function downloadHtml($id)
    {
        $cv = Resume::where('user_id', Auth::id())->findOrFail($id);
        $template = $cv->template;
        $cvData = $cv->content;
        $html = $template->render($cvData);
        
        $filename = strtolower($cv->user->first_name . '_' . $cv->user->last_name . '_CV.html');
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function save(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:cv_templates,id',
            'title' => 'nullable|string|max:255',
        ]);

        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates'
        ])->find(Auth::id());

        $template = CvTemplate::findOrFail($request->template_id);
        $cvData = $this->prepareCVData($user);

        $cv = Resume::create([
            'user_id' => Auth::id(),
            'cv_template_id' => $template->id,
            'content' => $cvData,
            'title' => $request->title ?? $user->first_name . ' ' . $user->last_name . ' - CV',
            'status' => 'draft',
            'version' => 1,
            'last_generated_at' => now(),
            'is_active' => true,
            'is_primary' => false,
        ]);

        $html = $template->render($cvData);

        return response()->json([
            'success' => true,
            'message' => 'CV saved successfully!',
            'cv_id' => $cv->id,
            'html' => $html
        ]);
    }

    public function show($id)
    {
        $cv = Resume::where('user_id', Auth::id())
            ->with(['template', 'color'])
            ->findOrFail($id);

        $template = $cv->template;
        $cvData = $cv->content;
        $html = $template->render($cvData);

        return view('jobseeker.pages.cv-preview', compact('cv', 'html'));
    }

    public function destroy($id)
    {
        $cv = Resume::where('user_id', Auth::id())->findOrFail($id);
        
        if ($cv->file_path) {
            Storage::disk('public')->delete($cv->file_path);
        }
        
        $cv->delete();

        return response()->json([
            'success' => true,
            'message' => 'CV deleted successfully!'
        ]);
    }

    private function prepareCVData($user)
    {
        $profile = $user->applicantProfile;
        
        return [
            'full_name' => $user->first_name . ' ' . $user->last_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'title' => $profile->current_job_title ?? $profile->title ?? 'Professional',
            'current_job_title' => $profile->current_job_title ?? 'Professional',
            'current_company' => $profile->current_company ?? '',
            'summary' => $profile->summary ?? '',
            'executive_summary' => $profile->summary ?? '',
            'profile_photo' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null,
            'location' => $profile->city ?? $profile->state ?? $profile->country ?? 'Remote',
            'city' => $profile->city ?? '',
            'state' => $profile->state ?? '',
            'country' => $profile->country ?? '',
            'skills' => $profile->skills ?? [],
            'languages' => $profile->languages ?? [],
            'interests' => $profile->interests ?? [],
            'portfolio_url' => $profile->portfolio_url ?? '',
            'github_url' => $profile->github_url ?? '',
            'linkedin_url' => $profile->linkedin_url ?? '',
            'website' => $profile->website ?? '',
            'education' => $user->educations->map(function($edu) {
                return [
                    'institution' => $edu->institute_name ?? '',
                    'degree' => $edu->education_title ?? '',
                    'field' => $edu->field_of_study ?? '',
                    'period' => $this->formatDateRange($edu->start_date, $edu->end_date, $edu->on_going),
                    'start_date' => $edu->start_date ? $edu->start_date->format('Y-m-d') : null,
                    'end_date' => $edu->end_date ? $edu->end_date->format('Y-m-d') : null,
                    'on_going' => $edu->on_going === 'yes',
                    'description' => $edu->description ?? '',
                    'gpa' => $edu->gpa ?? '',
                    'location' => $edu->city ?? $edu->state ?? $edu->country ?? '',
                ];
            })->toArray(),
            'experience' => $user->experiences->map(function($exp) {
                $responsibilities = [];
                if (!empty($exp->description)) {
                    $responsibilities = array_filter(array_map('trim', explode("\n", $exp->description)));
                }
                return [
                    'company' => $exp->company_name ?? '',
                    'title' => $exp->job_title ?? '',
                    'period' => $this->formatDateRange($exp->start_date, $exp->end_date, $exp->on_going),
                    'start_date' => $exp->start_date ? $exp->start_date->format('Y-m-d') : null,
                    'end_date' => $exp->end_date ? $exp->end_date->format('Y-m-d') : null,
                    'on_going' => $exp->on_going === 'yes',
                    'description' => $exp->description ?? '',
                    'responsibilities' => $responsibilities,
                    'location' => $exp->city ?? $exp->state ?? $exp->country ?? '',
                ];
            })->toArray(),
            'certifications' => $user->certificates->map(function($cert) {
                return [
                    'name' => $cert->sertification_title ?? '',
                    'institution' => $cert->institute_name ?? '',
                    'period' => $this->formatDateRange($cert->start_date, $cert->end_date, $cert->on_going),
                    'start_date' => $cert->start_date ? $cert->start_date->format('Y-m-d') : null,
                    'end_date' => $cert->end_date ? $cert->end_date->format('Y-m-d') : null,
                    'on_going' => $cert->on_going === 'yes',
                    'description' => $cert->description ?? '',
                    'location' => $cert->city ?? $cert->state ?? $cert->country ?? '',
                ];
            })->toArray(),
            'achievements' => [],
            'references' => [],
            'projects' => [],
        ];
    }

    private function formatDateRange($startDate, $endDate, $onGoing = 'no')
    {
        $start = $startDate ? date('M Y', strtotime($startDate)) : '';
        $end = $onGoing === 'yes' ? 'Present' : ($endDate ? date('M Y', strtotime($endDate)) : '');
        
        if ($start && $end) {
            return $start . ' - ' . $end;
        } elseif ($start) {
            return $start . ' - Present';
        }
        return '';
    }

    public function getTemplates()
    {
        $templates = CvTemplate::where('is_active', true)
            ->select('id', 'name', 'slug', 'thumbnail', 'description', 'category', 'style', 'layout_type', 'is_premium', 'is_default')
            ->get()
            ->map(function($template) {
                return [
                    'id' => $template->id,
                    'name' => $template->name,
                    'slug' => $template->slug,
                    'thumbnail' => $template->thumbnail_url,
                    'description' => $template->description,
                    'category' => $template->category,
                    'style' => $template->style,
                    'layout_type' => $template->layout_type,
                    'is_premium' => $template->is_premium,
                    'is_default' => $template->is_default,
                ];
            });

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }
}