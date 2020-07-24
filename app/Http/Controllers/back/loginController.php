<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Http\Requests\adminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    //
    public function getLogin(){
        return  view('back.auth.login');
    }
    public function login(adminLoginRequest $request){
//        return dd($request);
        $remember_me = $request->has('remember_me') ? true : false;
        if(Auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){

            return redirect()->route('admin.index');
        }else{
            $messages = 'some errors';


            return view('back.auth.login',compact('messages'));
        }
    }
    public function index(){
        return view('back.index');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('admin.form');
    }
}
