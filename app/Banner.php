<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Banner extends Model
{
    public function Author()
    {
      return $this->belongsTo('App\User','author_id');
    }
	public function bannerpage()
    {
        return $this->belongsToMany(Page::class,'banner_page','banner_id','page_id');
    }
// 	public function page()
// 	{
// 		return $this->belongsTo(Page::class);
// 	}
	
	public function pages()
	{
		return $this->belongsToMany(Page::class)->withTimestamps();
	}

  public function positions()
  {
  	return $this->belongsToMany('App\Position')->withTimestamps();
  }
}