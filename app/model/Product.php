<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','count','photo','active','vendor_id','category_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'category_id','password'
    ];

    public function getPhotoAttribute($val){
        return ($val !== null) ? asset( 'assest/images/'.$val) : '';
    }
}
