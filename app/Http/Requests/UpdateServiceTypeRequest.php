<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceTypeRequest extends FormRequest
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
                Rule::unique('service_types')->ignore($this->route('service_type'))->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string',
            'activities' => 'nullable|array',
            'activities.*' => 'integer|exists:activities,id',
        ];
    }

    /**
     * Customize the validation attribute names that apply to the request.
     */
    public function attributes()
    {
        return [
            'name' => __('name'),
            'description' => __('description'),
            'activities' => __('service_types.select_activities'),
        ];
    }
}
