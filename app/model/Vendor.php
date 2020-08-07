<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use notifiable;
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','mobile','email','password','logo','active','address','latitude','longitude','category_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'category_id','password'
    ];
    public function scopeSelection($q){
        return $q->select('id','name','mobile','address','email','logo','active','category_id');
    }

    public function scopeActive($q){
        return $q ->where('active',1);
    }
    public function getLogoAttribute($val)
    {
        return ($val !== null) ? asset( 'assest/images/'.$val) : '';
    }
    //   begin relation with category
    public function category(){
        return $this->belongsTo('App\model\MainCategory','category_id');
    }
    public function products(){
        return $this->hasMany('App\model\product','vendor_id');
    }

}
