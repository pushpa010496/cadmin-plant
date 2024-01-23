<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Klaravel\Ntrust\Traits\NtrustPermissionTrait;

class Permission extends Model
{
	use NtrustPermissionTrait;

    protected $fillable = ['name', 'display_name', 'description'];

    protected static $roleProfile = 'user';

    public function Author(){
      return $this->belongsTo('App\User','user_id');
    }
}
