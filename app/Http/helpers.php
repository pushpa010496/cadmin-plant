<?php

use App\Category;
use App\User;
use App\Product;

function getcat($categoryid)
{
		$category = \App\Category::where('parent_id',$categoryid)->pluck('name','id');
		return $category;
}

function getcatView($categoryid)
{
		$category = \App\Category::where('parent_id',$categoryid)->get();
		return $category;
}
function getproductnames($ids)
{
    $poductIds = explode(',',$ids);
    // dd($poductIds);
    return Product::whereIn('id',$poductIds)->get();
}

