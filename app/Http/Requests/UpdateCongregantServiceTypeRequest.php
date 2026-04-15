<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCongregantServiceTypeRequest extends FormRequest
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
            'activity_ids' => 'required|array|min:1',
            'activity_ids.*' => 'integer|exists:activities,id',
            'service_types' => 'required|array|min:1',
            'service_types.*' => 'required|array',
            'service_types.*.*' => 'integer|exists:service_types,id',
            'can_serve_consecutively' => 'required|boolean',
        ];
    }

    /**
     * Customize the validation attribute names that apply to the request.
     */
    public function attributes()
    {
        return [
            'activity_ids' => __('activities.index'),
            'service_types' => __('service_types.index'),
            'can_serve_consecutively' => __('willing_to_serve'),
        ];
    }
}
