<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class language extends Model
{

    protected $table = 'languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbr', 'local', 'name','direction','active','created_at','updated_at'
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


//    get Important selection

     public function scopeSelection($q){

        return $q -> select('id','abbr','local','name','direction','active');
      }

//      Get Active Attr with new Value

    public function getActive(){
        return   $this -> active == 1 ? 'مفعل'  : 'غير مفعل';
    }

}
