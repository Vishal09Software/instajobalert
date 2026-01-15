<?php

namespace App\Http\Requests\JobType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\JobType;

class UpdateJobTypeRequest extends FormRequest
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
        $jobType = $this->route('job_type');
        $jobTypeId = $jobType instanceof JobType ? $jobType->id : ($jobType ?? $this->input('job_type_id'));

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('job_types', 'title')->ignore($jobTypeId),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('job_types', 'slug')->ignore($jobTypeId),
            ],
            'parent_id' => 'nullable|exists:job_types,id',
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
            'parent_id' => 'parent job type',
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

