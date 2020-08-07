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
        'id','name','count','photo','active','vendor_id','category_id','translation_of','translation_lang','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getPhotoAttribute($val){
        return ($val !== null) ? asset( 'assest/images/'.$val) : '';
    }
    public function getActive(){
        return   $this -> active == 1 ? 'مفعل'  : 'غير مفعل';
    }
    public function scopeLangDef($q){
        return $q->where('translation_lang',default_lang());
    }

    /* Begin Relations */
    public function vendor(){
        return $this->belongsTo('App\model\Vendor','vendor_id');
    }
    public function category(){
        return $this->belongsTo('App\model\SubCategory','category_id');
    }

    public function languages(){
        return $this->hasMany(self::class,'translation_of');
    }
    /* End Relations */
}
