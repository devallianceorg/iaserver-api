<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;


class ApiLogin extends Controller
{
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
            return json_decode($content,true);
        } catch (\Exception $ex) {

            if($ex instanceof BadResponseException) {
                $content = $ex->getResponse();
                return  json_decode($content->getBody(), true);
            }
            // Si es un error no controlado...
            $error = $ex->getMessage();
            return compact('error');
        }
    }

    // Static utils
    public static function user($param=null) {
        $user = session('user');
        if($param) {
            return $user[$param];
        }

        return $user;
    }
    public static function name() {
        return self::user('name');
    }
    public static function roles() {
        return collect(self::user('acl')['roles']);
    }
    public static function permisos() {
        return collect(self::user('acl')['permisos']);
    }
    public static function token() {
        return session('token');
    }
    public static function apikey() {
        return env('X_IASERVER_APIKEY');
    }
    public static function owner($id) {
        if ($id == self::user('id')) {
            return true;
        }
        return false;
    }
    public static function isAdmin() {
        $roles = self::roles();
        if($roles->contains('superadmin')) {
            return true;
        }
        return false;
    }
}