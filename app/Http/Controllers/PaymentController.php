<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Validator\PaymentValidator;


class PaymentController extends Controller
{

    private $url_api;
    private $validate;
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaymentValidator $validate)
    {
        $this->url_api = env('APP_API');
        $this->validate = $validate;
    }

    /* Funcion que convierte la respueta xml del HTTP al json */
    public function xmlToJson($xml){
        return json_decode(json_encode(simplexml_load_string($xml->body())));
    }

    public function pagar(Request $request)
    {
        $validator = $this->validate->validatePagar();
        if ($validator->fails()) {
            $response = response([
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ]);
            return response()->json($response);
        }

        $response = Http::post($this->url_api.'/payment', [
            "phone"            => $request->phone,
            "document"         => $request->document,
            "value"            => $request->value,
            "id_user_payments" => $request->id_user_payments
        ]);
        // dd($response);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

    public function confirmarPago(Request $request)
    {
        $validator = $this->validate->validateConfirmarPago();
        if ($validator->fails()) {
            $response = response([
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ]);
            return response()->json($response);
        }

        $response = Http::put($this->url_api.'/payment', [
            "code"            => $request->code
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }
}
