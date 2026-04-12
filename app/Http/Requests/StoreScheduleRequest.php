<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
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
        return [
            'activity_id' => 'required|exists:activities,id',
            'start_date' => ['required', 'date',  Rule::date()->todayOrAfter()], // [TODO] Must be a date after or equal to start_time of the activity
            'end_date' => 'required|date|after_or_equal:start_date', // [TODO] Must be a date before or equal to end_time of the activity
            'service_types' => 'required|array',
            'service_types.*.include' => 'nullable|boolean',
            'service_types.*.count' => 'nullable|integer|min:1|required_with:service_types.*.include',
            'service_types.*.is_repeatable' => 'nullable|boolean',
        ];
    }
}
