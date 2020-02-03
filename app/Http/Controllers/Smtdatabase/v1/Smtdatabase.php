<?php

namespace App\Http\Controllers\Smtdatabase\v1;

use App\Http\Controllers\Controller;

class Smtdatabase extends Controller
{
    public function index()
    {
        $name = 'Smtdatabase';
        $version = 'v1';

        $output = compact('name','version');
    	return $output;
    }
}
