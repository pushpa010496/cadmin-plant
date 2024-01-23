<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
  protected $fillable = ['com_name','com_img'];
  public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
  public function company()
  {
    return $this->belongsTo('App\Company','company_id');
  }
  public function pcatalog(){
	    return $this->hasMany('App\CompanyCatalog');
	}
  public function ppress(){
      return $this->hasMany('App\CompanyPressrealese');
  }
  public function pwp(){
      return $this->hasMany('App\CompanyWhitePaper');
  }
  public function pvideo(){
      return $this->hasMany('App\CompanyVideo');
  }
  public function pproduct(){
      return $this->hasMany('App\Product');
  }
   public function pseocomp(){
      return $this->hasMany('App\SeoCompany');
  }
   public function pproject(){
      return $this->hasMany('App\CompanyProject');
  }
}