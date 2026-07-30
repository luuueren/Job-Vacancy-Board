<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
            'status' => 'required|in:pending,accepted,rejected',

            'aiGeneratedScore' => 'nullable|numeric|min:0|max:100',

            'aiGeneratedFeedback' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'The application status is required.',
            'status.in' => 'The selected status is invalid.',

            'aiGeneratedScore.numeric' => 'The AI score must be a number.',
            'aiGeneratedScore.min' => 'The AI score cannot be less than 0.',
            'aiGeneratedScore.max' => 'The AI score cannot be greater than 100.',

            'aiGeneratedFeedback.string' => 'The AI feedback must be a valid text.',
        ];
    }
}
