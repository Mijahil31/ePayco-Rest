<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserValidator {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function rulesRegistroCliente()
    {
        return [
            "name"     => "required",
            "email"    => "required|email",
            "phone"    => "required",
            "document" => "required|numeric"
        ];
    }

    public function rulesConsultaUsuario()
    {
        return [
            "phone"    => "required",
            "document" => "required|numeric"
        ];
    }

    public function messages()
    {
        return [];
    }

    public function validateRegistroCliente()
    {
        return Validator::make($this->request->all(), $this->rulesRegistroCliente(), $this->messages());
    }

    public function validateConsultaUsuario()
    {
        return Validator::make($this->request->all(), $this->rulesConsultaUsuario(), $this->messages());
    }

}
