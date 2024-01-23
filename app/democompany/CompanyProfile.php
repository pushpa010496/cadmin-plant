<?php

namespace App\democompany;

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
      return $this->hasMany('App\democompany\CompanyCatalog','company_profile_id')->orderBy('id','desc');
  }
  public function ppress(){
      return $this->hasMany('App\democompany\CompanyPressrealese','company_profile_id')->orderBy('id','desc');
  }
  public function pwp(){
      return $this->hasMany('App\democompany\CompanyWhitepaper','company_profile_id')->orderBy('id','desc');
  }
  public function pvideo(){
      return $this->hasMany('App\democompany\CompanyVideo','company_profile_id')->orderBy('id','desc');
  }
  public function pproduct(){
    
      return $this->hasMany('App\democompany\Product','company_profile_id')->orderBy('id','desc');
  }
   public function pseocomp(){
      return $this->hasMany('App\SeoCompany','company_profile_id');
  }
}