<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\Category;
class subSubCategory extends Model
{
    protected $fillable = ['subsubcat_name', 'cat_id','subcat_id','subsubcat_img','subsubcat_des'];
   
}
