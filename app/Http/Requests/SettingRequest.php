<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Logo & Branding
            'app_name' => 'nullable|string|max:255',
            'app_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico,svg|max:1024',

            // Mail Settings
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email|max:255',

            // Footer
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'footer_desc' => 'nullable|string|max:1000',

            // Social Media
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',

            // Contact
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'location_map_url' => 'nullable|url|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'app_name.max' => 'The app name may not be greater than 255 characters.',
            'app_url.url' => 'The app URL must be a valid URL.',
            'app_url.max' => 'The app URL may not be greater than 255 characters.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'favicon.image' => 'The favicon must be an image.',
            'favicon.mimes' => 'The favicon must be a file of type: jpeg, png, jpg, gif, ico, svg.',
            'favicon.max' => 'The favicon may not be greater than 1MB.',
            'mail_host.max' => 'The mail host may not be greater than 255 characters.',
            'mail_port.integer' => 'The mail port must be an integer.',
            'mail_port.min' => 'The mail port must be at least 1.',
            'mail_port.max' => 'The mail port may not be greater than 65535.',
            'mail_username.max' => 'The mail username may not be greater than 255 characters.',
            'mail_password.max' => 'The mail password may not be greater than 255 characters.',
            'mail_encryption.in' => 'The mail encryption must be either TLS or SSL.',
            'mail_from_address.email' => 'The mail from address must be a valid email address.',
            'mail_from_address.max' => 'The mail from address may not be greater than 255 characters.',
            'footer_logo.image' => 'The footer logo must be an image.',
            'footer_logo.mimes' => 'The footer logo must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'footer_logo.max' => 'The footer logo may not be greater than 2MB.',
            'footer_desc.max' => 'The footer description may not be greater than 1000 characters.',
            'facebook.url' => 'The Facebook URL must be a valid URL.',
            'facebook.max' => 'The Facebook URL may not be greater than 255 characters.',
            'twitter.url' => 'The Twitter URL must be a valid URL.',
            'twitter.max' => 'The Twitter URL may not be greater than 255 characters.',
            'instagram.url' => 'The Instagram URL must be a valid URL.',
            'instagram.max' => 'The Instagram URL may not be greater than 255 characters.',
            'linkedin.url' => 'The LinkedIn URL must be a valid URL.',
            'linkedin.max' => 'The LinkedIn URL may not be greater than 255 characters.',
            'youtube.url' => 'The YouTube URL must be a valid URL.',
            'youtube.max' => 'The YouTube URL may not be greater than 255 characters.',
            'contact_email.email' => 'The contact email must be a valid email address.',
            'contact_email.max' => 'The contact email may not be greater than 255 characters.',
            'contact_phone.max' => 'The phone number may not be greater than 50 characters.',
            'contact_address.max' => 'The contact address may not be greater than 500 characters.',
            'location_map_url.url' => 'The location map URL must be a valid URL.',
            'location_map_url.max' => 'The location map URL may not be greater than 500 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'app_name' => 'app name',
            'app_url' => 'app URL',
            'logo' => 'logo',
            'favicon' => 'favicon',
            'mail_host' => 'mail host',
            'mail_port' => 'mail port',
            'mail_username' => 'mail username',
            'mail_password' => 'mail password',
            'mail_encryption' => 'mail encryption',
            'mail_from_address' => 'mail from address',
            'footer_logo' => 'footer logo',
            'footer_desc' => 'footer description',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'contact_email' => 'contact email',
            'contact_phone' => 'phone number',
            'contact_address' => 'contact address',
            'location_map_url' => 'location map URL',
        ];
    }
}

