<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Occupation;

class UpdateJobRequest extends FormRequest
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
        $job = $this->route('job');
        $jobId = $job instanceof Occupation ? $job->id : ($job ?? $this->input('job_id'));

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('occupations', 'slug')->ignore($jobId),
            ],
            'type' => 'nullable|string|max:255',
            'amount' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:500',
            'job_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('occupations', 'job_id')->ignore($jobId),
            ],
            'posted_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:posted_at',
            'employment_type' => 'nullable|string|max:255',
            'seniority_level' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:job_categories,id',
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
            'slug.unique' => 'The slug has already been taken.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'job_id.required' => 'The job ID field is required.',
            'job_id.unique' => 'The job ID has already been taken.',
            'link.url' => 'The link must be a valid URL.',
            'link.max' => 'The link may not be greater than 500 characters.',
            'posted_at.date' => 'The posted at must be a valid date.',
            'expires_at.date' => 'The expires at must be a valid date.',
            'expires_at.after' => 'The expires at must be after the posted at date.',
            'category_id.exists' => 'The selected category does not exist.',
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
            'title' => 'job title',
            'slug' => 'slug',
            'job_id' => 'job ID',
            'category_id' => 'category',
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

