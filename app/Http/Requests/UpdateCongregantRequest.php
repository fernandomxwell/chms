<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateCongregantRequest extends FormRequest
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
            'full_name' => 'required|string|max:100',
            'gender' => ['required', new Enum(Gender::class)],
            'date_of_birth' => ['nullable', 'date', Rule::date()->todayOrBefore()],
            'phone_number' => ['nullable', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => 'nullable|email|max:100',
            'date_of_baptism' => ['nullable', 'date', Rule::date()->todayOrBefore(), 'after_or_equal:date_of_birth'],
            'status' => ['required', new Enum(Status::class)],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'phone_number.regex' => __('validation.phone_number_regex'),
        ];
    }
}
