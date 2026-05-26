<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\posts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'user_name' => 'sometimes|nullable|string',
            'staff'     => 'sometimes|nullable|string',
            'mensage'   => 'sometimes|nullable|string',
            'img'       => 'sometimes|nullable|string'
        ];
    }
}
