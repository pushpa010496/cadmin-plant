<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;
use App\Article;
class User extends Authenticatable
{
    use NtrustUserTrait; // add this trait to your user model

    /*
     * Role profile to get value from ntrust config file.
     */
    protected static $roleProfile = 'user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','city'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
     public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
     public function countresearchdatadept()
    {
        return $this->hasMany("App\ResearchDataDept",'author_id');
    }
    public function article()
    {
        return $this->hasMany("App\Article",'author_id');
    }

    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
