<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // يجب التأكد من أن المستخدم مسجّل الدخول فعلاً هنا،
        // بدل الاعتماد فقط على middleware الراوت (طبقة حماية إضافية).
        return auth()->check();
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'resume_option' => [
                'required',
                Rule::in(['existing', 'new']),
            ],

            'resume_id' => [
                Rule::requiredIf(fn () => $this->resume_option === 'existing'),
                'nullable',
                'uuid',
            ],

            'resume_file' => [
                Rule::requiredIf(fn () => $this->resume_option === 'new'),
                'nullable',
                'file',
                // mimes + mimetypes معًا لتحقق أقوى من نوع الملف الفعلي
                // (mimes يعتمد على الامتداد، mimetypes يفحص المحتوى الحقيقي)
                'mimes:pdf',
                'mimetypes:application/pdf',
                'max:5120',
            ],
        ];
    }

    /**
     * Configure additional validation.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            if (
                $this->resume_option === 'existing' &&
                $this->filled('resume_id')
            ) {
                $exists = \App\Models\Resume::where('id', $this->resume_id)
                    ->where('userId', auth()->id())
                    ->exists();

                if (! $exists) {
                    $validator->errors()->add(
                        'resume_id',
                        'The selected resume is invalid.'
                    );
                }
            }
        });
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'resume_option.required' => 'Please choose a resume option.',

            'resume_option.in' => 'Invalid resume option.',

            'resume_id.required' => 'Please select one of your existing resumes.',

            'resume_id.uuid' => 'Invalid resume identifier.',

            'resume_file.required' => 'Please upload a resume.',

            'resume_file.file' => 'The uploaded file is invalid.',

            'resume_file.mimes' => 'Only PDF files are allowed.',

            'resume_file.mimetypes' => 'The uploaded file does not appear to be a valid PDF.',

            'resume_file.max' => 'The file may not be greater than 5 MB.',
        ];
    }
}
