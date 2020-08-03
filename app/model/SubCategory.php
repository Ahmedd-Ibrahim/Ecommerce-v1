<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Model\MainCategory;
class SubCategory extends Model
{
    protected $table = 'sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','parent_id','category_id','translation_lang', 'translation_of', 'name','slug','photo','active','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

    /* get sub categories onley default language */
    public function scopeDefault($q){
        return $q->where('translation_lang',default_lang());
    }
    // Show photo in view
    public function getPhotoAttribute($val){
        return ($val !== null) ? asset( 'assest/images/admin/'.$val) : '';
    }
    ########### begin Relations ############
    /* get another tables of languages for this table */
    public function mainLang(){
  return $this->hasMany(self::class, 'translation_of');
    }
    public function sublang(){
  return $this->belongsTo(self::class, 'translation_of');
    }

    // Relation betwwen this model and parent Categories

    public function subCategory(){
        return $this->belongsTo(MainCategory::class,'category_id');
    }

    ########### End Relations ############

}
