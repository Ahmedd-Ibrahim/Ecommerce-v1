<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\languageRequests;
use App\model\language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;


class languagesController extends Controller
{
    public function index(){
        $languages = language::select()->paginate(PAGINATION_COUNT);
        return view('back.languages.index',compact('languages'));
    }
    public function create(){
        return view('back.languages.add');
    }
    public function store(languageRequests $request){
        try {
            if(!$request->has('active')){
                $request->request->add(['active'=> 0]);
            }
            language::create($request->except(['_token']));
            return redirect()->route('admin.languages')->with(['success'=> 'تم أضافة اللغة بنجاح!']);
        }
        catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=> 'هناك خطأ ما حاول فيما بعد']);
        }
    }
    public function edit($id){
        $language = language::find($id);
        if(!$language){
            return redirect()->route('admin.languages')->with(['error'=>'هذه اللغة غير موجوده']);
        }
        return view('back.languages.edit',compact('language'));
    }

    public function update(languageRequests $request,$id){

        $language = language::find($id);
        try{
            if(!$request->has('active')){
                $request->request->add(['active'=> 0]);
            }
            $language->update($request->except('_token'));
            return redirect()->route('admin.languages')->with(['success'=>'تم تعديل اللغة بنجاح']);
        }catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=>'هناك خطأ حاول فيما بعد']);
        }
    }
    public function destroy($id){

        $language = language::find($id);
        if(!$language){
            return redirect()->route('admin.languages')->with(['error'=>'هذه اللغة غير موجوده']);
        }
        try{
            $language->delete();
            return redirect()->route('admin.languages')->with(['success'=>'تم الحذف  بنجاح']);
        }catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=>'هناك خطأ حاول فيما بعد']);
        }
    }
}
