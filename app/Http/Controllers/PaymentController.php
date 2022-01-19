<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Validator\UserValidator;


class UserController extends Controller
{

    private $url_api;
    private $validate;
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserValidator $validate)
    {
        $this->url_api = env('APP_API');
        $this->validate = $validate;
    }

    /* Funcion que convierte la respueta xml del HTTP al json */
    public function xmlToJson($xml){
        return json_decode(json_encode(simplexml_load_string($xml->body())));
    }

    public function getUser($id){
        $response = Http::get($this->url_api.'/user/'.$id);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

    public function consultaUsuario(Request $request)
    {

        $validator = $this->validate->validateConsultaUsuario();
        if ($validator->fails()) {
            $response = [
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ];
            return response()->json($response);
        }

        $response = Http::get($this->url_api.'/user', [
            'document' => $request->document,
            'phone' => $request->phone
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

    public function registroCliente(Request $request)
    {

        $validator = $this->validate->validateRegistroCliente();
        if ($validator->fails()) {
            $response = response([
                "success"       => false,
                "cod_error"      => 422,
                "message_error" => $validator->errors()
            ]);
            return response()->json($response);
        }

        $response = Http::post($this->url_api.'/user', [
            'name'=>$request->name,
            'document' => $request->document,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }
}
