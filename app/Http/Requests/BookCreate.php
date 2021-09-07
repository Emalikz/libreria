<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCreate extends FormRequest
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
        $rules =  [
            'id' => 'nullable',
            'title' => 'required',
            'author' => 'required',
            'number_pages' => 'required|integer'
        ];
        if ($this->method() == "POST") {
            $rules['isbn_code'] = 'required|unique:App\Models\Book,isbn_code|string|max:13';
        }
        return $rules;
    }
}
