<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WalletValidator {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function rulesRecargarBilletera()
    {
        return [
            "phone"    => "required",
            "document" => "required|numeric",
            "value"    => "required|numeric"
        ];
    }

    public function rulesConsultarSaldo()
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

    public function validateRecargarBilletera()
    {
        return Validator::make($this->request->all(), $this->rulesRecargarBilletera(), $this->messages());
    }

    public function validateConsultarSaldo()
    {
        return Validator::make($this->request->all(), $this->rulesConsultarSaldo(), $this->messages());
    }

}
