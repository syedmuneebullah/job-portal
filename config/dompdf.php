<?php
// config/dompdf.php

return [
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => [
        'DOMPDF_FONT_CACHE' => storage_path('fonts/'),
        'DOMPDF_TEMP_DIR' => sys_get_temp_dir(),
        'DOMPDF_CHROOT' => base_path(),
        'DOMPDF_FONT_DIR' => storage_path('fonts/'),
        'DOMPDF_ENABLE_FONT_SUBSETTING' => true,
        'DOMPDF_PDF_BACKEND' => 'CPDF',
        'DOMPDF_DEFAULT_MEDIA_TYPE' => 'screen',
        'DOMPDF_DEFAULT_PAPER_SIZE' => 'a4',
        'DOMPDF_DEFAULT_FONT' => 'sans-serif',
        'DOMPDF_DPI' => 96,
        'DOMPDF_ENABLE_PHP' => false,
        'DOMPDF_ENABLE_REMOTE' => true,
        'DOMPDF_ENABLE_CSS_FLOAT' => false,
        'DOMPDF_ENABLE_JAVASCRIPT' => false,
        'DOMPDF_ENABLE_HTML5PARSER' => true,
        'DOMPDF_ENABLE_FONTSUBSETTING' => true,
        'DOMPDF_FONT_HEIGHT_RATIO' => 1.1,
        'DOMPDF_ENABLE_CSS' => true,
    ],
];