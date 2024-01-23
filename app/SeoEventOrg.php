<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoEventOrg extends Model
{
    public function seoevnorg(){

    	 return $this->belongsTo('App\EventOrg','event_org_id');
    }
}
