<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Event extends Model
{
    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
    public function eventprofile()
	{
	   return $this->hasOne('App\EventProfile');
	}
	public function eventorg()
    {
        return $this->belongsTo('App\EventOrg','event_org_id');
    }
  public function eventseo(){
      return $this->hasMany('App\SeoEvent');
    }

  public function eventcat()
    {
        return $this->belongsTo('App\EventCategory','cat_id');
    }
}