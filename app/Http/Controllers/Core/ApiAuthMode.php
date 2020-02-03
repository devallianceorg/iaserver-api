<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class ApiAuthMode extends Controller
{
    public $headers = [];

    public function __construct($mode='JWT') {
        switch ($mode) {
            case 'JWT':
                $this->jwt(ApiLogin::token());
                break;
            case 'JWTSOCIAL':
                $this->social(ApiLogin::token());
                break;
            case 'APIKEY':
                $this->apikey(ApiLogin::apikey());
                break;
        }
    }

    public function jwt($token) {
        $this->setHeaders([
            'X-IASERVER-AUTH' => 'JWT',
            'Authorization' => "Bearer {$token}"
        ]);

    }

    public function social($token) {
        $this->setHeaders([
            'X-IASERVER-AUTH' => 'JWTSOCIAL',
            'Authorization' => "Bearer {$token}"
        ]);

    }

    public function apikey($apikey) {
        $this->setHeaders([
            'X-IASERVER-AUTH' => 'APIKEY',
            'X-IASERVER-APIKEY' => $apikey
        ]);

    }

    private function setHeaders($headers) {
        $this->headers = [
            'headers' => $headers
        ];
    }
}
