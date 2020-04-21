<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  public function roles()
  {
      return $this->belongsToMany(Role::class,'permission_role');
  }
}