<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienSavetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Reglas del formulario.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "first_name" => "required|string|max:20",
            "second_name" => "nullable|string|max:20",
            "first_lastname" => "required|string|max:20",
            "second_lastname" => "required|string|max:20",
            "document_id" => "exists:App\Models\DocumentType,id",
            "identification_number" => "required|numeric|unique:clients,identification_number",
            "birth_date" => "required|date",
            "address" => "nullable|string",
            "telephone_number" => "nullable|numeric",
        ];
        if ($this->method() == "POST") {
            $rules["identification_number"] = "required|unique:App\Models\Client,identification_number";
        }
        return $rules;
    }
}
