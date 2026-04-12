<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCongregantServiceTypeRequest extends FormRequest
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
            'congregant_id' => 'required|exists:congregants,id',
            'activity_ids' => 'required|array|min:1',
            'activity_ids.*' => 'integer|exists:activities,id',
            'service_type_ids' => 'required|array|min:1',
            'service_type_ids.*' => 'integer|exists:service_types,id',
            'can_serve_consecutively' => 'required|boolean',
        ];
    }
}
