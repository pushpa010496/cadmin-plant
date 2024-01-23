<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTags extends Model
{
    //
    public function tags(){
      return $this->belongsTo('App\Tags','tag_id');
    }
    public function categories(){
      return $this->belongsTo('App\Category','category_id');
    }
    public function products() {
        return $this->belongsToMany('App\Product');
    }
}
