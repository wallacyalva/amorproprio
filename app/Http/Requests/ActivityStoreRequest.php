<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityStoreRequest extends FormRequest
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
            'title'         => 'required|string',
            'description'   => 'required|string',
            'link'          => 'required|string',
            'img'           => 'required|string'
        ];
    }
}
