<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestProduct extends Model{
 
  protected $table = 'products';
  protected $guarded = ['id'];
  public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
  public function company()
  {
    return $this->belongsTo('App\Company','company_id');
  }
  public function compprofile()
  {
    return $this->belongsTo('App\CompanyProfile','company_profile_id');
  }

  public function categories(){
    return $this->belongsToMany('App\Category')
      ->withTimestamps();
  }
}