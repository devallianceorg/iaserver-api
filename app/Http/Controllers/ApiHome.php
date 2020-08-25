<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiHome extends Controller
{
    public function index()
    {
		return [
			'api' => 'online',
			'name' => 'IAServer',
			'version' => '6.2'
		];
    }
}
