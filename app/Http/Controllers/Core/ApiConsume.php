<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Log;

class ApiConsume extends Controller
{
    private $host;

    private $route;
    private $consume_route;

    private $headers = [];
    private $status = [];

    private $error;
    private $response;
    private $download = false;

    public function __construct($host=null)
    {
        if($host) {
            $this->setHost($host);
        }
    }

    public function setHost($host=null)
    {
        $this->host = $host;
    }

    public function setAuth(ApiAuthMode $authMode)
    {
        $this->headers = $authMode->headers;
    }

    public function forceDownload() {
        $this->download = true;
    }

    public function hasError() {
        if($this->error!=null) {
            Log::error([$this->consume_route,$this->error]);
            return true;
        } else {
            return false;
        }
    }
    public function getError() {
        return $this->error;
    }
    public function getResponse() {
        return $this->response;
    }
    public function response() {
        return $this->response;
    }

    private function generateUri($route) {
        $this->route = $route;

        $this->consume_route = join('/',[
            $this->host,
            $this->route
        ]);
    }

    public function request($method,$route,$params=[]) {
        $this->generateUri($route);

        // Consume
        try {
            $guzzle = new Client($this->headers);
            $consumeApi = $guzzle->request($method,$this->consume_route,['query' => $params]);

            $content = $consumeApi->getBody()->getContents();

            if($this->download) {
                $req = $content;
            } else {
                // Obtiene el contenido de la respuesta, la transforma a json
                $req = json_decode($content,true);
                if($req==null){
	   	        if(!empty($content)) { 
		            $error = 'BadContentToJsonResponseException';
			    $message = $content;
		            $this->error = compact('error','message');

		            return $this;		   
			}

                    $error = 'JsonBadResponseException';
                    $this->error = compact('error');

                    return $this;
                }
            }
        } catch (\Exception $ex) {
            if($ex instanceof BadResponseException) {
                $content = $ex->getResponse();
                $jsonBody = json_decode($content->getBody(), true);

                $this->error =  $jsonBody;

                return $this;
            }

            $error = $ex->getMessage();
            $this->error = compact('error');

            return $this;
        }


        if(isset($req['error'])) {
            $this->status = 'error';
            $this->error = $req;
        } else {
            $this->status = 'done';
            $this->response = $req;
        }

        return $this;
    }

    // Crud
    public function get($uri,$params=[])
    {
        return $this->request('GET',$uri,$params);
    }
    public function post($uri,$params=[])
    {
        return $this->request('POST',$uri,$params);
    }
    public function delete($uri,$params=[])
    {
        return $this->request('DELETE',$uri,$params);
    }
}
