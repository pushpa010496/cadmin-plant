<?php

namespace App\democompany;

use Illuminate\Database\Eloquent\Model;
use app\subCategory;
class Company extends Model
{
	public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
   	public function companyprofile(){
	    return $this->hasMany('App\CompanyProfile');
	}
	public function companycatalogs()
	{
	    return $this->hasMany('App\democompany\CompanyCatalog');
	}
	public function companypress()
	{
	    return $this->hasMany('App\democompany\CompanyPressrealese');
	}
	public function companywp()
	{
	    return $this->hasMany('App\democompany\CompanyWhitePaper');
	}
	public function companyvideo()
	{
	    return $this->hasMany('App\democompany\CompanyVideo');
	}
	public function companyproduct()
	{
	    return $this->hasMany('App\democompany\Product');
	}
}