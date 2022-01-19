<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class UserController extends Controller
{

    private $url_api;
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url_api = env('APP_API');
    }

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
        $response = Http::get($this->url_api.'/user', [
            'document' => $request->document,
            'phone' => $request->phone
        ]);
        $response = $this->xmlToJson($response);
        return response()->json($response);
    }

    public function registroCliente(Request $request)
    {
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
