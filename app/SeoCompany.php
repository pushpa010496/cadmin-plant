<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoCompany extends Model
{
  public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
  public function company()
  {
    return $this->belongsTo('App\Company','company_id');
  }
  public function seocompanypro()
  {
    return $this->belongsTo('App\CompanyProfile','company_profile_id');
  }
 
}