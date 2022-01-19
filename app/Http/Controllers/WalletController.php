<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Validator\WalletValidator;


class WalletController extends Controller
{

    private $url_api;
    private $validate;
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WalletValidator $validate)
    {
        $this->url_api = env('APP_API');
        $this->validate = $validate;
    }

    /* Funcion que convierte la respueta xml del HTTP al json */
    public function xmlToJson($xml){
        return json_decode(json_encode(simplexml_load_string($xml->body())));
    }

    public function consultarSaldo(Request $request)
    {
        $validator = $this->validate->validateConsultarSaldo();
        if ($validator->fails()) {
            $response = response([
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ]);
            return response()->json($response);
        }

        $response = Http::get($this->url_api.'/wallet', [
            'document' => $request->document,
            'phone' => $request->phone
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

    public function recargarSaldo(Request $request)
    {
        $validator = $this->validate->validateRecargarBilletera();
        if ($validator->fails()) {
            $response = [
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ];
            return response()->json($response);
        }

        $response = Http::put($this->url_api.'/wallet', [
            'document' => $request->document,
            'phone'    => $request->phone,
            'value'    => $request->value
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

}
