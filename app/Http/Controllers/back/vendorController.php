<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\mainCategoryRequest;
use App\Http\Requests\vendorsRequest;
use App\model\MainCategory;
use App\model\Vendor;
use App\Notifications\vendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class vendorController extends Controller
{
    public function index()
    {
        $vendors =  Vendor::selection()->paginate(PAGINATION_COUNT);

        return view('back.vendor.index',compact('vendors'));
    }
    public function create()
    {
        $categories = mainCategory::active()->selection()->where('translation_of',0)->get();
        return view('back.vendor.add',compact('categories'));
    }
    public function store(vendorsRequest $request)
    {

        try {
            $filePath = "";
            if($request->has('logo')){
                $filePath =  uploadImage('vendors',$request->logo);
            }
            $request->has('active') ? $active = 1 : $active = 0;

          $vendor =  Vendor::create([
                "address" => $request->address,
                "name" => $request->name,
                "mobile" => $request->mobile,
                "email" => $request->email,
                "category_id" => $request->category_id,
                "password" => bcrypt($request->password),
                "active" => $active,
                "logo" => $filePath,
              "latitude" => $request->latitude,
              "longitude" => $request->longitude,

            ]);
            Notification::send($vendor,new vendorCreated($vendor));
            return redirect()->route('admin.vendor')->with(['success'=> "تم أضافه التاجر بنجاح"]);

        }catch (\Exception $ex){
            return $ex;
            return redirect()->route('admin.vendor')->with(['error'=> "حاول مرة اخري"]);
        }



    }
    public function edit($id)
    {
        $categories = mainCategory::active()->selection()->where('translation_of',0)->get();
        $vendor = Vendor::find($id);
        if(!$vendor){
            return redirect()->route('admin.vendor')->with(['error'=> 'هذا التاجر غير موجود']);
        }
        return view('back.vendor.edit',compact('vendor','categories'));
    }
    public function update($id, vendorsRequest $request){

        try {
            $vendor = Vendor::find($id);
//        check if this Vendor if not exist redirect
            if(!$vendor){
                return redirect()->route('admin.vendor')->with(['error'=>'هذا التاجر غير موجود']);
            }

//        get active status and set it to 0 or 1
            $active='';
            isset($request->active)? $active = 1 : $active = 0 ;
//        update  Image if the request has upload image
            DB::beginTransaction();
            if($request->has('logo')){
                $path =  uploadImage('vendors',$request->logo);
                Vendor::where('id',$id)
                    ->update([
                        'logo' => $path
                    ]);
            }
            $data = $request->except('_token','logo','password','id');
            if($request->has('password')){
                $data['password'] =  bcrypt($request->password);
            }
            Vendor::where('id',$id)
                ->update($data);
            DB::commit();
            return redirect()->route('admin.vendor')->with(['success'=> 'تم تعديل التاجر بنجاح']);
        }catch (\Exception $ex){
            DB::rollback();
            redirect()->route('admin.vendor')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }
    }

    public function activation($id)
    {
        try {
            $vendor = Vendor::find($id);
            if(!$vendor){
                return redirect()->route('admin.vendor')->with(['error'=>'هذا القسم غير موجود']);
            }
            if($vendor->active == 0){
                $vendor->update(['active'=> 1]);
                return redirect()->route('admin.vendor')->with(['success'=> 'تم تفعيل القسم بنجاح']);
            }elseif ($vendor->active == 1){

                $vendor->update(['active'=> 0]);
                return redirect()->route('admin.vendor')->with(['success'=> 'تم إلغاء التفعيل بنجاح']);
            }
        }catch (\Exception $ex){
            return  redirect()->route('admin.vendor')->with(['error'=>'هناك خطأ ما حاول مرة أخري']);
        }
    }
}
