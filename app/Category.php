<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\subCategory;
use Nestable\NestableTrait;

class Category extends Model
{
		use NestableTrait;

    protected $parent = 'parent_id';

    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
 
  	public function products()
	{
	    return $this->belongsToMany('App\Product')
	      ->withTimestamps();
	}
}