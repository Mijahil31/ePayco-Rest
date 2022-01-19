<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PaymentValidator {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function rulesPagar()
    {
        return [
            "phone"            => "required",
            "document"         => "required|numeric",
            "value"            => "required|numeric",
            "id_user_payments" => "required|numeric"
        ];
    }

    public function rulesConfirmarPago()
    {
        return [
            "code"    => "required",
        ];
    }

    public function messages()
    {
        return [];
    }

    public function validatePagar()
    {
        return Validator::make($this->request->all(), $this->rulesPagar(), $this->messages());
    }

    public function validateConfirmarPago()
    {
        return Validator::make($this->request->all(), $this->rulesConfirmarPago(), $this->messages());
    }

}
