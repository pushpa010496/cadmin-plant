<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Page extends Model{
    protected $parent = 'parent_id';

    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
   	public function sliders(){
	    return $this->belongsToMany('App\Slider','page_slider','page_id','slider_id')->withTimestamps();
	}
	public function banners()
    {
        return $this->hasMany(Banner::class);
    }
	public function seop(){

		return $this->hasOne('App\SeoPage');

	}
}