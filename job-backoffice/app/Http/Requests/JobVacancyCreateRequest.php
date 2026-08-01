<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'salary' => 'required|numeric|min:0',
        'type' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'jobCategoryId' => 'required|exists:job_categories,id',

        'companyId' => auth()->user()->role === 'admin'
            ? 'required|exists:companies,id'
            : 'nullable',
    ];
}

    public function messages(): array
    {
        return [
            "title.required" => "The job title is required.",
            "title.max" => "The job title may not be greater than 255 characters.",
            "title.string" => "The job title must be a string.",

            "location.required" => "The job location is required.",
            "location.max" => "The job location may not be greater than 255 characters.",
            "location.string" => "The job location must be a string.",

            "salary.required" => "The salary is required.",
            "salary.numeric" => "The salary must be a number.",
            "salary.min" => "The salary must be at least 0.",

            "type.required" => "The job type is required.",
            "type.max" => "The job type may not be greater than 255 characters.",
            "type.string" => "The job type must be a string.",

            "description.required" => "The job description is required.",
            "description.max" => "The job description may not be greater than 255 characters.",
            "description.string" => "The job description must be a string.",

            "jobCategoryId.required" => "The job category is required.",
            "jobCategoryId.exists" => "The selected job category is invalid.",
            "jobCategoryId.max" => "The job category may not be greater than 255 characters.",
            "jobCategory.string" => "The job category must be a string.",

            'companyId.required' => 'Please select a company.',
            'companyId.exists' => 'The selected company is invalid.',
        ];
    }
}


