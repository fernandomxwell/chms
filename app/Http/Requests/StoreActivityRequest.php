<?php

namespace App\Http\Requests;

use App\Enums\RecurrenceDay;
use App\Enums\RecurrenceEndCondition;
use App\Enums\RecurrenceFrequency;
use App\Rules\NoScheduleConflict;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreActivityRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('activities')->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string',
            'frequency' => ['required', 'string', new Enum(RecurrenceFrequency::class)],
            'interval' => 'nullable|numeric|required_unless:frequency,NONE|min:1',
            'byday' => 'nullable|array|required_if:frequency,WEEKLY',
            'byday.*' => ['string', new Enum(RecurrenceDay::class)],
            'end_condition' => ['nullable', 'string', new Enum(RecurrenceEndCondition::class)],
            'until' => 'nullable|date|after_or_equal:start_time|required_if:end_condition,on_date',
            'count' => 'nullable|numeric|required_if:end_condition,after_occurrences|min:1',
            'start_time' => [
                'required',
                'date',
                new NoScheduleConflict(
                    $this->start_time,
                    [
                        'frequency' => $this->frequency,
                        'interval' => $this->interval,
                        'byday' => $this->byday,
                        'end_condition' => $this->end_condition,
                        'until' => $this->until,
                        'count' => $this->count,
                    ]
                ),
            ],
        ];
    }
}
