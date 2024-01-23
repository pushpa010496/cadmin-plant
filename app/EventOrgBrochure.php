<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use App\User;
use App\Event;
class EventOrgBrochure extends Model
{
    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
   	public function eventorg()
    {
        return $this->belongsTo('App\EventOrg','event_org_id');
    }
}