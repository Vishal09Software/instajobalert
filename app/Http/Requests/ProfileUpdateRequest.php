<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        // For job applications (when job_id is present), allow existing emails
        $emailRules = ['required', 'email', 'max:255'];
        if (!$this->has('job_id')) {
            $emailRules[] = Rule::unique('users', 'email')->ignore($userId);
        }

        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => $emailRules,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'professional_title' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string|max:5000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume' => $this->has('job_id') ? 'required|file|mimes:pdf,doc,docx|max:5120' : 'nullable|file|mimes:pdf,doc,docx|max:5120',
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
            'first_name.max' => 'The first name may not be greater than 255 characters.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'date_of_birth.date' => 'The date of birth must be a valid date.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'professional_title.max' => 'The professional title may not be greater than 255 characters.',
            'cover_letter.max' => 'The cover letter may not be greater than 5000 characters.',
            'avatar.image' => 'The avatar must be an image.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg, gif.',
            'avatar.max' => 'The avatar may not be greater than 2MB.',
            'resume.file' => 'The resume must be a file.',
            'resume.mimes' => 'The resume must be a file of type: pdf, doc, docx.',
            'resume.max' => 'The resume may not be greater than 5MB.',
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
            'first_name' => 'first name',
            'last_name' => 'last name',
            'email' => 'email address',
            'phone' => 'phone number',
            'date_of_birth' => 'date of birth',
            'location' => 'location',
            'professional_title' => 'professional title',
            'cover_letter' => 'cover letter',
            'avatar' => 'avatar',
            'resume' => 'resume',
        ];
    }
}
