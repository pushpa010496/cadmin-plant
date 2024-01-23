<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\Category;
class subCategory extends Model
{
    protected $fillable = ['subcat_name', 'cat_id','subcat_img','subcat_des'];
   
}
