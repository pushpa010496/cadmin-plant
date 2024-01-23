<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyEnquiry extends Model
{
	public function company(){
		return $this->belongsTo('App\Company','company_id');
	}
	public function companies(){
		return $this->belongsTo('App\Company','company_id');
	}

	public function product(){
		return $this->belongsTo('App\Product','product_id');
	}
}