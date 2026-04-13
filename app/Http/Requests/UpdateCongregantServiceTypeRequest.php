<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCongregantServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
}
