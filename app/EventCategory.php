<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class EventCategory extends Model
{
	use NestableTrait;

    protected $parent = 'parent_id';

    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
   	
}


