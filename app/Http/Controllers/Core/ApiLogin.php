<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;


class ApiLogin extends Controller
{
    public function index() {
        return view('login');
    }

    public function start() {
        $response = $this->doLogin();

        if(isset($response['error']))
        {
            return redirect(route('login'))->withErrors(['auth.api'=>$response['error']]);
        }

        if(isset($response['token'])) {
            $token = $response['token'];
            $user = $this->getUserData($token);

            session()->put('token', $token);
            session()->put('user', $user);

            return redirect()->route('home');
        } else {
            return $response;
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }

    public function getUserData($token) {
        $authRoute = env('IASERVER_AUTH_API').'/me';
        $params = [
            'token' => $token
        ];

        try {
            $guzzle = new Client();
            $consumeApi = $guzzle->request('get',$authRoute,['query' => $params]);

            // Obtiene el contenido de la respuesta, la transforma a json
            $content = $consumeApi->getBody()->getContents();
            $req = json_decode($content,true);
        } catch (BadResponseException $ex) {
            $content = $ex->getResponse();
            $error = json_decode($content->getBody(), true);
            return $error;
        }

        return $req;
    }

    private function doLogin() {
        $authRoute = env('IASERVER_AUTH_API').'/login';
        $params = request()->all();

        try {
            $guzzle = new Client();
            $consumeApi = $guzzle->request('POST',$authRoute,['query' => $params]);

            // Obtiene el contenido de la respuesta, la transforma a json
            $content = $consumeApi->getBody()->getContents();
            $req = json_decode($content,true);
        } catch (BadResponseException $ex) {
            $content = $ex->getResponse();
            $error = json_decode($content->getBody(), true);
            return $error;
        }

        return $req;
    }

    // Static utils
    public static function user($param=null) {
        $user = session('user');
        if($param) {
            return $user[$param];
        }

        return $user;
    }
    public static function token() {
        return session('token');
    }

    public static function apikey() {
        return env('X_IASERVER_APIKEY');
    }
}