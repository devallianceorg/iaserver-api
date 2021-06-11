<?php

namespace App\Http\Controllers\IAServer;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Session;

class Filter extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    public static function turnoSession()
    {
        $default = 'M';
        return self::makeSession('turno_session',$default);
    }

    public static function dateSession($sessionName="date_session")
    {
        $default = Carbon::now()->format('d-m-Y');
        return self::makeSession($sessionName,$default);
    }

    public static function makeSession($input_request_name,$default="")
    {
        $input_value = Request::input($input_request_name);
        if(is_null($input_value))
        {
            if(!Session::has($input_request_name))
            {
                Session::put($input_request_name, $default);
            }
        } else {
            Session::put($input_request_name, $input_value);
        }
        return Session::get($input_request_name);
    }
}
