<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
	protected $fillable = ['comp_name','contact_name','comp_logo','email','phone','profile_type','start_date','end_date','country','website','track_url','track_id','fax','address','active_flag','comp_sts','product_url','banner_image','banner_url','linkedin','twitter','job_title','contact_email','contact_mobile','billing_comp_name','billing_contact_person','billing_contact_number','billing_address','billing_country','billing_email','billing_value','vat_tax_gst','po_no','po_date','tax','facebook','created_at','updated_at','author_id','meta_position','meta_icbm','meta_title','meta_keywords','meta_description','og_title','og_description','og_keywords','og_image','og_video','meta_region','email1','email2','email3','enq_email','form_type','package','company_id','services'];
    //

public function company(){
		return $this->belongsTo('App\Company','company_id');
	}
public function author(){
      return $this->belongsTo('App\User','author_id');
    }
}
