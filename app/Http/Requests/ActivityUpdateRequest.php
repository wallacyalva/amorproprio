<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\activities\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'title'         => 'sometimes|nullable|string',
            'description'   => 'sometimes|nullable|string',
            'link'          => 'sometimes|nullable|string',
            'img'           => 'sometimes|nullable|string'
        ];
    }
}
