<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\mainCategoryRequest;
use App\model\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class mainCategoryController extends Controller
{
    public function index(){

        $default_lang = default_lang();
        $categories = MainCategory::where('translation_lang',$default_lang)->selection()->get();

        return view('back.mainCategory.index',compact('categories'));
    }
    public function create(){
        return view('back.mainCategory.add');
    }

    public function store(mainCategoryRequest $request){

        try {
            DB::beginTransaction();
        $category = collect( $request-> category);
        $filter =$category->filter(function ($val,$key){
            return $val['abbr'] == default_lang();
        });
        $default_category = array_values($filter->all())[0];
        $filePath = "";
        if($request -> has('photo')){
            $filePath = uploadImage('mainCategory',$request->photo);
        }
         $default_category_id = MainCategory::insertGetId([
             'translation_lang' => $default_category['abbr'],
             'translation_of' => 0,
             'name' =>  $default_category['name'],
             'slug' =>  $default_category['name'],
             'photo'  => $filePath
         ]);

        $categories = $filter =$category->filter(function ($val,$key){
            return $val['abbr'] != default_lang();
        });
        if(isset($categories) && $categories->count())
        {
            $categories_arr = [];
            foreach ($categories as $cat)
            {
                $categories_arr[]= [
                    'translation_lang' => $cat['abbr'],
                    'translation_of' => $default_category_id,
                    'name' =>  $cat['name'],
                    'slug' =>  $cat['name'],
                    'photo'  => $filePath
                ];
            }
            MainCategory::insert($categories_arr);
        }
        DB::commit();
        return redirect()->route('admin.categories')->with(['success'=> 'تم أضافة القسم بنجاح']);
        }
        catch (\Exception $ex){
            DB::rollback();
            redirect()->route('admin.categories')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }
    }

    public function edit($id){
       $mainCategory = MainCategory::with('categoey')->selection()->find($id);
       if(!$mainCategory){
         return  redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
       }

       return view('back.mainCategory.edit',compact('mainCategory'));

    }
    public function update($id, mainCategoryRequest $request){

        try {

        $main_category = MainCategory::find($id);
//        check if this category not exist redirect
        if(!$main_category){
            return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
        }
        $categoey = array_values($request-> category) [0];  // enter inside the first array
//        get active status and set it to 0 or 1
        $active='';
        isset($categoey['active'])? $active = 1 : $active = 0 ;
//        update  Image if the request has upload image

//        update the category which have default language
        MainCategory::where('id',$id)
            ->update([
                'name' => $categoey['name'],
                'active' => $active,

            ]);

            if($request->has('photo')){
                $path =  uploadImage('mainCategory',$request->photo);
                MainCategory::where('id',$id)
                    ->update([
                       'photo' => $path
                    ]);
            }
        return redirect()->route('admin.categories')->with(['success'=> 'تم تعديل القسم بنجاح']);
        }catch (\Exception $ex){
            redirect()->route('admin.categories')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }
    }
    public function destroy($id){
        try {
            $category = MainCategory::find($id);
            $vendors = $category->vendor();
            if(isset($vendors) && $vendors->count() > 0){
                return redirect()->route('admin.categories')->with(['error'=>'لا يمكن حذف هذا القسم']);
            }else{

                ######## Begin prepare category group id #########
                $id_arr = [];
                if (isset($category->categoey) && $category->categoey->count() > 0){
                    foreach ($category->categoey as $ids){
                        $id_arr[] = $ids->id; // Id for sub languages
                    }
                }

                $id_arr [] = $category->id; // id for default language
                $category->destroy($id_arr); // delete all
                ######## prepare category group id #########

                ################ Begin delete this category image from project files ##########
                $local_path = str::before( app_path(),'app');
                $img_path = Str::after($category->photo,'assest/');
                $image = $local_path."assest/".$img_path;
                unlink($image); // delete the Image
                ################ End delete this category image from project files ##########
                return redirect()->route('admin.categories')->with(['success'=> 'تم حذف القسم بنجاح']);
            }

        }catch (\Exception $ex){

            redirect()->route('admin.categories')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }

    }
    public function activation($id)
    {
        try {
            $category = MainCategory::find($id);
            if(!$category){
                return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
            }
            if($category->active == 0){
                $category->update(['active'=> 1]);
                return redirect()->route('admin.categories')->with(['success'=> 'تم تفعيل القسم بنجاح']);
            }elseif ($category->active == 1){

                $category->update(['active'=> 0]);
                return redirect()->route('admin.categories')->with(['success'=> 'تم إلغاء التفعيل بنجاح']);
            }
        }catch (\Exception $ex){
          return  redirect()->route('admin.categories')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }
    }
}
