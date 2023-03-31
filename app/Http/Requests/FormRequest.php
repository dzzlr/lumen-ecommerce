<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class FormRequest
{
    use ProvidesConvenienceMethods;

    public Request $req;

    public function __construct(Request $request, array $messages = [], array $customAttributes = [])
    {
        $this->req = $request;

        $this->prepareForValidation();

        if (!$this->authorize()) throw new UnauthorizedException;

        $this->validate($this->req, $this->rules(), $messages, $customAttributes);
    }

    public function all()
    {
        return $this->req->all();
    }

    public function get(string $key, $default = null)
    {
        return $this->req->get($key, $default);
    }

    protected function prepareForValidation()
    {
        //
    }

    protected function authorize()
    {
        return true;
    }

    protected function rules()
    {
        return [];
    }
}