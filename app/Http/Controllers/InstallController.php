<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class InstallController extends Controller
{
    /**
     * Step 1 — Welcome
     */
    public function welcome()
    {
        return view('install.welcome');
    }

    /**
     * Step 2 — Requirements check
     */
    public function requirements()
    {
        $requirements = [
            'php_version' => [
                'label' => 'PHP >= 8.1',
                'value' => PHP_VERSION,
                'pass'  => version_compare(PHP_VERSION, '8.1.0', '>='),
            ],
            'extensions'  => [],
            'permissions' => [],
        ];

        $requiredExtensions = [
            'openssl', 'pdo', 'mbstring', 'tokenizer', 'json', 'curl',
            'fileinfo', 'ctype', 'xml', 'bcmath', 'zip', 'gd',
        ];

        foreach ($requiredExtensions as $ext) {
            $requirements['extensions'][$ext] = [
                'label' => $ext,
                'value' => extension_loaded($ext) ? 'Enabled' : 'Missing',
                'pass'  => extension_loaded($ext),
            ];
        }

        $paths = [
            'storage'           => storage_path(),
            'storage/framework' => storage_path('framework'),
            'storage/logs'      => storage_path('logs'),
            'bootstrap/cache'   => base_path('bootstrap/cache'),
            '.env'              => base_path('.env'),
        ];

        foreach ($paths as $label => $path) {
            if ($label === '.env') {
                $writable = is_writable($path) || (!file_exists($path) && is_writable(base_path()));
            } else {
                $writable = is_writable($path);
            }

            $requirements['permissions'][$label] = [
                'label' => $label,
                'value' => $writable ? 'Writable' : 'Not Writable',
                'pass'  => $writable,
            ];
        }

        $allPass = $requirements['php_version']['pass'];
        foreach ($requirements['extensions'] as $ext)  $allPass = $allPass && $ext['pass'];
        foreach ($requirements['permissions'] as $p)   $allPass = $allPass && $p['pass'];

        $requirements['all_pass'] = $allPass;

        return view('install.requirements', compact('requirements'));
    }

    /**
     * Step 3 — Database form
     */
    public function databaseForm()
    {
        return view('install.database');
    }

    /**
     * Step 3 — Database save + test connection
     */
    public function databaseSave(Request $request)
    {
        $validated = $request->validate([
            'db_host'     => 'required|string',
            'db_port'     => 'required|numeric',
            'db_name'     => 'required|string',
            'db_user'     => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        try {
            $dsn = "mysql:host={$validated['db_host']};port={$validated['db_port']};dbname={$validated['db_name']}";
            new \PDO($dsn, $validated['db_user'], $validated['db_password'] ?? '', [
                \PDO::ATTR_TIMEOUT => 5,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);

            session(['install.db' => $validated]);

            return redirect()->route('install.app-config')
                ->with('success', 'Database connection successful!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['db_connection' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Step 4 — App config form
     */
    public function appConfigForm()
    {
        if (!session('install.db')) {
            return redirect()->route('install.database');
        }
        return view('install.app-config');
    }

    /**
     * Step 4 — App config save
     */
    public function appConfigSave(Request $request)
    {
        $validated = $request->validate([
            'app_name'          => 'required|string|max:100',
            'app_url'           => 'required|url',
            'app_env'           => 'required|in:local,production',
            'app_debug'         => 'nullable|in:0,1',
            'mail_host'         => 'nullable|string',
            'mail_port'         => 'nullable|numeric',
            'mail_user'         => 'nullable|string',
            'mail_password'     => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name'    => 'nullable|string',
        ]);

        session(['install.app' => $validated]);

        return redirect()->route('install.super-admin');
    }

    /**
     * Step 5 — Super admin form
     */
    public function superAdminForm()
    {
        if (!session('install.db') || !session('install.app')) {
            return redirect()->route('install.database');
        }
        return view('install.super-admin');
    }

    /**
     * Step 5 — Super admin save → seedha finalize
     */
    public function superAdminSave(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:150',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        session(['install.admin' => $validated]);

        return redirect()->route('install.finalize');
    }

    /**
     * Step 6 — Finalize installation
     */
    public function finalize()
    {
        $db    = session('install.db');
        $app   = session('install.app');
        $admin = session('install.admin');

        if (!$db || !$app || !$admin) {
            return redirect()->route('install.welcome')
                ->withErrors(['error' => 'Installation session expired. Please start again.']);
        }

        try {
            // 1. .env update
            $this->updateEnv([
                'APP_NAME'           => '"' . $app['app_name'] . '"',
                'APP_ENV'            => $app['app_env'],
                'APP_DEBUG'          => !empty($app['app_debug']) ? 'true' : 'false',
                'APP_URL'            => $app['app_url'],

                'DB_CONNECTION'      => 'mysql',
                'DB_HOST'            => $db['db_host'],
                'DB_PORT'            => $db['db_port'],
                'DB_DATABASE'        => $db['db_name'],
                'DB_USERNAME'        => $db['db_user'],
                'DB_PASSWORD'        => $db['db_password'] ?? '',

                'MAIL_MAILER'        => 'smtp',
                'MAIL_HOST'          => $app['mail_host'] ?? '',
                'MAIL_PORT'          => $app['mail_port'] ?? 587,
                'MAIL_USERNAME'      => $app['mail_user'] ?? '',
                'MAIL_PASSWORD'      => $app['mail_password'] ?? '',
                'MAIL_FROM_ADDRESS'  => $app['mail_from_address'] ?? 'hello@example.com',
                'MAIL_FROM_NAME'     => '"' . ($app['mail_from_name'] ?? $app['app_name']) . '"',
            ]);

            // 2. Config reload
            Artisan::call('config:clear');

            // 3. Runtime DB config
            config([
                'database.connections.mysql.host'     => $db['db_host'],
                'database.connections.mysql.port'     => $db['db_port'],
                'database.connections.mysql.database' => $db['db_name'],
                'database.connections.mysql.username' => $db['db_user'],
                'database.connections.mysql.password' => $db['db_password'] ?? '',
            ]);
            DB::purge('mysql');

            // 4. Key generate
            Artisan::call('key:generate', ['--force' => true]);

            // 5. Migrate
            // Artisan::call('migrate', ['--force' => true]);

            // 6. Super admin create
            \App\Models\User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'first_name'        => $admin['first_name'],
                    'last_name'         => $admin['last_name'],
                    'password'          => Hash::make($admin['password']),
                    'user_type'         => 'admin',
                    'status'            => 'active',
                    'email_verified_at' => now(),
                ]
            );

            // 7. Storage link
            try {
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                // ignore
            }

            // 8. Lock file
            File::put(storage_path('installed.lock'), json_encode([
                'installed_at' => now()->toDateTimeString(),
                'version'      => '1.0.0',
                'app_name'     => $app['app_name'],
            ]));

            // 9. Session clear
            session()->forget(['install.db', 'install.app', 'install.admin']);

            return redirect()->route('install.complete');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Installation failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Step 7 — Complete page
     */
    public function complete()
    {
        return view('install.complete');
    }

    /**
     * Helper — update .env
     */
    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            if (!file_exists(base_path('.env.example'))) {
                throw new \Exception('.env.example file not found.');
            }
            copy(base_path('.env.example'), $envPath);
        }

        $content = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $value = (string) $value;

            if ($value !== '' && preg_match('/\s/', $value) && strpos($value, '"') !== 0) {
                $value = '"' . $value . '"';
            }

            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $content);
    }
}