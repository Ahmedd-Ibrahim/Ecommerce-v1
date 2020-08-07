<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\model\Product;
use App\model\productLanguage;
use App\model\SubCategory;
use App\model\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class productController extends Controller
{
    public function index()
    {

        $products = product::langDef()->with('vendor','category',)->get();
// return $products;
        return view('back.products.index',compact('products'));
    }
    public function create()
    {
        $sub = SubCategory::default()->get();
        $vendors = Vendor::active()->get();
        return view('back.products.add',compact('sub','vendors'));
    }

    public function store(productRequest $request)
    {
    try
    {
        DB::beginTransaction();
        $products = collect($request->product);
        $filter = $products->filter(function ($val,$key){
            return $val['abbr'] == default_lang();
        });
        $defualt_product = array_values($filter->all())[0];
        $filePath = "";
        if($request -> has('photo')){
            $filePath = uploadImage('products',$request->photo);
        }
        isset($request->active) ? $active = 1 : $active = 0;
        $default_get_id = product::insertGetId([
            'name' =>$defualt_product['name'],
            'translation_lang'=> $defualt_product['abbr'],
            'active' => $active,
            'translation_of'=>0,
            'count' =>  $request->count,
            'vendor_id'=> $request->vendor,
            'category_id'=>$request->category,
            'photo' => $filePath,
            'created_at' =>date('Y-m-d H:i:s')
        ]);

        /*  insert other languages */
        $other_lang = $products->filter(function($val,$key){ // ignor default language from collect
            return $val['abbr'] !== default_lang();
        });
        if(isset($other_lang) && $other_lang->count() > 0){
            $arr_value = [];
            foreach($other_lang as $lang){
                $arr_value [] = [
                    'name' =>$lang['name'],
                    'translation_lang'=> $lang['abbr'],
                    'translation_of'=>$default_get_id,
                    'active' => $active,
                    'count' =>  $request->count,
                    'vendor_id'=> $request->vendor,
                    'category_id'=>$request->category,
                    'photo' => $filePath,
                    'created_at' =>date('Y-m-d H:i:s')
                ];
            }
            product::insert($arr_value);
        }
        DB::commit();
        return redirect()->route('admin.product')->with(['success'=>"تم اضافة المنتج بنجاح"]);
    }catch(\Exception $ex){
        return $ex;
        DB::rollback();
        return redirect()->route('admin.product')->with(['error'=>"هناك خطأ ما"]);
    }
    }
    public function edit($id)
    {
        $product = product::find($id);

        return view('back.products.edit',compact('product'));
    }

    public function update($id, Request $request)
    {
        try{
            DB::beginTransaction();
            $product = product::find($id);
            if (!$product) {
                return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);
            }
            isset($request->active) ? $active = 1 : $active = 0; // Set status 0 or 1
            /* update photo if exist  */
            if ($request->has('photo')) {
                ################ Begin delete this category image from project files ##########
                $local_path = str::before(app_path(), 'app');
                $img_path = Str::after($product->photo, 'assest/');
                $image = $local_path . "assest/" . $img_path;
                unlink($image); // delete the Image

                ################ End delete this category image from project files ##########
                $path = '';
                $path = uploadImage('products', $request->photo);
                $product->update([
                    'photo' => $path,
                ]);
            }

            /* update default language */
            $product->update([
                'name' => $request->name,
                'active' => $active,
            ]);
            $request_collection = collect($request->mainLang); // another languages in collectino from request

            if (isset($product->languages) && $product->languages()->count() > 0) { // loop inside languages if exist in database

                foreach ($product->languages as $category) {

                    $col = $request_collection->where('cat_id', $category->id); // which request category will insert

                    if ($col !== 'null') {
                        /*  get values from the request & update  */
                        foreach ($col as $colum) {
                            isset($colum['active']) ? $active = 1 : $active = 0;

                            $category->update([
                                'name' => $colum['name'],
                                'active' => $active,
                                'photo' => $path,
                            ]);
                        }
                    } else {
                        return redirect()->route('admin.product')->with(['error' => 'هذا المنتج غير موجود']);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.product')->with(['success' => 'تم تعديل المنتج بنجاح']);
        } catch(\Exception $ex){
            return $ex;
            DB::rollback();
            return redirect()->route('admin.product')->with(['error' => 'هناك خطأ ما']);
        }

    }
    public function activation()
    {

    }

    public function destroy($id){

    }
}
