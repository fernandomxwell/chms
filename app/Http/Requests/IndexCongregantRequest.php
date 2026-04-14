<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexCongregantRequest extends FormRequest
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
            'search' => 'nullable|string|max:100',
            'status' => ['nullable', new Enum(Status::class)],
            'gender' => ['nullable', new Enum(Gender::class)],
        ];
    }
}
