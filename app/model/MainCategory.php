<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{

    protected $table = 'main_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'translation_lang', 'translation_of', 'name','slug','photo','active','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    public function scopeActive($q){  // get only active rows
        return $q -> where('active',1);
    }
    public function scopeSelection($q){

        return $q->select('id','translation_lang','name','slug','photo','active','translation_of');
    }
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset( 'assest/images/admin/'.$val) : '';
    }
    public function categoey(){
        return $this->hasMany(self::class, 'translation_of');
    }
//   begin relation with vendors
    public function vendor(){
        return $this->hasMany('App\model\Vendor','category_id');
    }
}
