<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\model\Product;
use App\model\SubCategory;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index()
    {
        $products = product::get();
        return view('back.products.index',compact('products'));
    }
    public function create()
    {
        $sub = SubCategory::default()->get();
        return view('back.products.add',compact('sub'));
    }

    public function store(Request $request)
    {

        $filePath = "";
        if($request -> has('photo')){
            $filePath = uploadImage('products',$request->photo);
        }
        product::create([
            'name' =>$request->name,
            'photo' => $filePath,
            'count' => $request->count,
            'active' => $request->active
        ]);
        return 'uploded';
    }

    public function edit()
    {

    }

    public function activation()
    {

    }

    public function destroy($id){

    }
}
