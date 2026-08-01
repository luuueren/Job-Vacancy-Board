<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $companyId = auth()->user()->role === 'admin'
            ? $this->route('company')
            : auth()->user()->company?->id;

        $rules = [

            // Company Information
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($companyId),
            ],

            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',

            // Company Owner
            'owner_name' => 'required|string|max:255',

            'owner_password' => 'nullable|string|min:8|confirmed',
        ];

        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            // Company
            'name.required' => 'The company name is required.',
            'name.unique' => 'A company with this name already exists.',

            'website.url' => 'The website must be a valid URL.',

            // Owner
            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',

            'owner_password.min' => 'The password must be at least 8 characters.',
            'owner_password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
