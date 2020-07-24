<?php

use Illuminate\Support\Facades\Config;

// get languages
function getLang(){
    return \App\model\language::active()->selection()->get();
}
// get default language
function default_lang(){
    return config::get('app.locale');
}
 function uploadImage($folder,$image){
    $image->store('/',$folder);
    $fileName = $image->hashName();
    $path = $folder . '/' . $fileName;
    return $path;
 }
