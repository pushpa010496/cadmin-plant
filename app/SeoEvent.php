<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoEvent extends Model
{
     public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
    public function seoe(){
	    return $this->belongsTo('App\Event','event_id');
	  }
}
