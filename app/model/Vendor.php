<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','mobile','email','logo','active','category_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'category_id'
    ];
    public function scopeSelection($q){
        return $q->select('name','mobile','email','logo','active','category_id');
    }

    public function scopeActive($q){
        return $q ->where('active',1);
    }
    //   begin relation with category
    public function category(){
        return $this->belongsTo('App\model\MainCategory','category_id');
    }
}
