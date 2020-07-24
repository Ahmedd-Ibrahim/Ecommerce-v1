<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\model\Vendor;
use Illuminate\Http\Request;

class vendorController extends Controller
{
    public function index()
    {
        $vendors =  Vendor::selection()->with('category')->paginate(PAGINATION_COUNT);

        return view('back.vendor.index',compact('vendors'));
    }
    public function create()
    {
        return view('back.vendor.add');
    }
    public function store()
    {

    }
    public function edit()
    {

    }
    public function update()
    {

    }

}
