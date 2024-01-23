<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
   public function categories(){
    return $this->belongsToMany('App\Category')
      ->withTimestamps();
  }
  public function subtags() {
        return $this->hasMany('SubTags');
    }
}
