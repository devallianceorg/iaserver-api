<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public function permissions()
  {
      return $this->belongsToMany(Permission::class,'permission_role');

  }
}