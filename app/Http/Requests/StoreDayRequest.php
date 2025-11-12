<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDayRequest extends FormRequest
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
            //
            "start" => ['required', 'array'],
            "end" => ['required', 'array'],
            "price" => ["required", 'array'],
            "start.*" => ["required","string","min:2", "date_format:H:i"],
            "end.*" => ['required',"string","min:2", "date_format:H:i"],
            "price.*" => ["required", 'integer'],
            
            "name" => ['required', "date"],
            "field_id" => ["required", "exists:fields,id"],
        ];
    }
}
