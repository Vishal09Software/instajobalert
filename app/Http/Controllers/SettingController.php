<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageUploadService
    ) {}

    public function index()
    {
        $settingsArray = Setting::pluck('value', 'key')->toArray();

        $envSettings = [
            'app_name' => env('APP_NAME', ''),
            'app_url' => env('APP_URL', ''),
            'mail_host' => env('MAIL_HOST', ''),
            'mail_port' => env('MAIL_PORT', ''),
            'mail_username' => env('MAIL_USERNAME', ''),
            'mail_password' => env('MAIL_PASSWORD', ''),
            'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS', ''),
            'mail_from_name' => env('MAIL_FROM_NAME', ''),
            'mail_mailer' => env('MAIL_MAILER', 'smtp'),
        ];

        $settingsArray = array_merge($settingsArray, $envSettings);

        return view('admin.setting.index', compact('settingsArray'));
    }

    public function update(SettingRequest $request)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $data = $request->validated();

        $editor = new DotenvEditor();
        $editor->load(base_path('.env'));

        $envFields = [
            'app_name' => 'APP_NAME',
            'app_url' => 'APP_URL',
            'mail_host' => 'MAIL_HOST',
            'mail_port' => 'MAIL_PORT',
            'mail_username' => 'MAIL_USERNAME',
            'mail_password' => 'MAIL_PASSWORD',
            'mail_encryption' => 'MAIL_ENCRYPTION',
            'mail_from_address' => 'MAIL_FROM_ADDRESS',
            'mail_from_name' => 'MAIL_FROM_NAME',
            'mail_mailer' => 'MAIL_MAILER',
        ];

        $fileFields = ['logo', 'favicon', 'footer_logo'];

        foreach ($data as $key => $value) {
            // Handle file uploads
            if (in_array($key, $fileFields) && $request->hasFile($key)) {
                $value = $this->imageUploadService->uploadImage(
                    $request->file($key),
                    'uploads/settings',
                    $settings[$key] ?? null,
                    $key . '_'
                );
            }

            // Store in .env file if it's an env field
            if (isset($envFields[$key])) {
                if ($key === 'mail_password' && empty($value)) {
                    continue;
                }

                $editor->setKey($envFields[$key], $value ?? '');
            } else {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value ?? '']
                );
            }
        }

        $editor->save();
        \Artisan::call('config:clear');
        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully');
    }
}
