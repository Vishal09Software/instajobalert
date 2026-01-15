<?php

namespace App\Http\Requests\JobType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreJobTypeRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:job_types,title',
            'slug' => 'required|string|max:255|unique:job_types,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'parent_id' => 'nullable|exists:job_types,id',
            'status' => 'required|boolean',
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
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'slug.required' => 'The slug field is required.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'The slug has already been taken.',
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'parent_id.exists' => 'The parent job type does not exist.',
            'status.required' => 'The status field is required.',
            'status.boolean' => 'The status must be true or false.',
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
            'title' => 'job type title',
            'slug' => 'slug',
            'status' => 'status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('title') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }
}

