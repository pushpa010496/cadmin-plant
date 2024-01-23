<?php

namespace App;

use Klaravel\Ntrust\Traits\NtrustRoleTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use NtrustRoleTrait;
    protected $fillable = ['name', 'display_name', 'description'];

    protected static $roleProfile = 'user';

    public function Author(){
      return $this->belongsTo('App\User','author_id');
        }
        
}
