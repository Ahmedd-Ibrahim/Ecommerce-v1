<?php

namespace App\model;

use App\Observers\MainCategoryObserver;
use Illuminate\Database\Eloquent\Model;
use App\model\SubCategory;
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
    /**
     * @var mixed
     */


    protected static function boot()
    {
       parent::boot();
        MainCategory::observe(MainCategoryObserver::class);
    }

    public function scopeDefault($q){   // get only default rows
        return $q -> where('translation_lang',default_lang());
    }
    public function scopeActive($q){  // get only active rows
        return $q -> where('active',1);
    }
    public function getActive($q){
        return $q->select('active');
    }
    public function scopeSelection($q){

        return $q->select('id','translation_lang','name','slug','photo','active','translation_of');
    }
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset( 'assest/images/admin/'.$val) : '';
    }
#################### begin relations #################
   ### Begin get translation of this table ###
    public function categoey(){
        return $this->hasMany(self::class, 'translation_of');
    }
   ### End get translation of this table ###
//   begin relation with vendors
    public function vendor(){
        return $this->hasMany('App\model\Vendor','category_id');
    }

//    get sub language id
    public function scopeSubIds(){
        return $this->categoey()->id;
    }

    public function subCategory(){
        return $this->hasMany(SubCategory::class,'category_id');
    }
    #################### End relations #################
}
