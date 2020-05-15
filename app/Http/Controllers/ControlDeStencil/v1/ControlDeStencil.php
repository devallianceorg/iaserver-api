<?php

namespace App\Http\Controllers\ControlDeStencil\v1;

use App\Http\Controllers\Controller;

class ControlDeStencil extends Controller
{
    public function index()
    {
        $name = 'controldestencil';
        $version = 'v1';

        $output = compact('name','version');
    	return $output;
    }
}
