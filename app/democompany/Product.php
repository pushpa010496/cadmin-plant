<?php



namespace App\democompany;



use Illuminate\Database\Eloquent\Model;



class Product extends Model{



  protected $table = 'products';

  protected $fillable = ['com_name','com_img'];



  public function Author(){

      return $this->belongsTo('App\User','author_id');

    }

  public function company()

  {



    return $this->belongsTo('App\Company','company_id');

  }

  public function compprofile()

  {

    return $this->belongsTo('App\democompany\CompanyProfile','company_profile_id');

  }



  public function categories(){

    

    return $this->belongsToMany('App\Category')

      ->withTimestamps();

  }

 }