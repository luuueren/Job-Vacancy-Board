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
        return [

            // Company
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')
                    ->ignore($this->route('company')),
            ],

            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',

            // Owner
            'owner_name' => auth()->user()->role === 'admin'
                ? 'required|string|max:255'
                : 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'The company name is required.',
            'name.unique' => 'A company with this name already exists.',

            'website.url' => 'The website must be a valid URL.',

            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',
        ];
    }
}
