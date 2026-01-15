<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category') ?? $this->input('category_id');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('job_categories', 'title')->ignore($categoryId),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('job_categories', 'slug')->ignore($categoryId),
            ],
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:job_categories,id',
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
            'icon.max' => 'The icon may not be greater than 255 characters.',
            'parent_id.exists' => 'The parent category does not exist.',
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
            'title' => 'category title',
            'slug' => 'slug',
            'icon' => 'icon',
            'status' => 'status',
            'parent_id' => 'parent category',
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

