<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Partner extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function Author(){
      return $this->belongsTo('App\User','author_id');
    }
}