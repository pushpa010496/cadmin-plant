<?php

namespace App;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class ProductLandingPage extends Model{

    protected $table = 'product_landingpages';
    protected $guarded = ['id'];

    public function product(){
        return $this->hasMany('App\Product','product_id');
    }
    
}