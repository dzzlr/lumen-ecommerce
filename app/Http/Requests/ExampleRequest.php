<?php

namespace App\Http\Requests;

class ExampleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'age' => 'required|int'
        ];
    }

    public function prepareForValidation()
    {
        $this->req->merge([
            'age' => 18
        ]);
    }
}