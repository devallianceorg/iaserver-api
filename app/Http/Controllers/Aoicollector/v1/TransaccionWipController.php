<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Aoicollector\Model\TransaccionWip;
use App\Http\Controllers\Controller;

class TransaccionWipController extends Controller
{
  public function scopeCountOk($query)
  {
      return TransaccionWip::where('trans_code',1)->count();
  }
}