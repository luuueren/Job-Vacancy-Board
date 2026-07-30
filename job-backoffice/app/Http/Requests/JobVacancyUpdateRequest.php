<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
     public function rules(): array
{
    return [
        'title' => 'required|string|max:255|',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'salary' => 'required|numeric|min:0',
        "type" => 'required|string|max:255',
        'jobCategoryId' => 'required|exists:job_categories,id',
        'companyId' => 'required|exists:companies,id',
    ];
}

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.unique' => 'A job vacancy with this title already exists.',
            'title.max' => 'The job title may not be greater than 255 characters.',
            'title.string' => 'The job title must be a string.',

            'description.required' => 'The job description is required.',
            'description.string' => 'The job description must be a string.',

            'location.required' => 'The job location is required.',
            'location.max' => 'The job location may not be greater than 255 characters.',
            'location.string' => 'The job location must be a string.',

            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',

            'type.required' => 'The job type is required.',
            'type.in' => 'The selected job type is invalid.',

            'companyId.required' => 'The company is required.',
            'companyId.exists' => 'The selected company is invalid.',

            'jobCategoryId.required' => 'The job category is required.',
            'jobCategoryId.exists' => 'The selected job category is invalid.',
        ];
    }
}
