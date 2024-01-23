<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchKeyword extends Model
{
     protected $table = 'search_keyword';
      protected $fillable = ['keyword','url','status','meta_title','meta_keywords','meta_description','og_title','og_description','og_keywords'];
}
