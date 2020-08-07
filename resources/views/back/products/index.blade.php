@extends('back.include.layout')
@section('content')
    ﻿ <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> المنتجات </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> المنتجات
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">كل المنتجات</h4>
                                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                  <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                  </div>
                                </div>

                                @include('back.include.alerts.success')
                                @include('back.include.alerts.errors')
                                <div class="card-content collapse show">
                                  <div class="card-body card-dashboard">
                                    <p class="card-text">هنا يتم عرض جميع منتجات الموقع</p>
                                    <table class="table table-striped table-bordered dom-jQuery-events text-center">
                                      <thead>
                                        <tr>
                                          <th>اسم المنتج</th>
                                          <th>اسم التاجر</th>
                                          <th>القسم</th>
                                          <th>التفعيل</th>
                                          <th>صورة المنتج</th>
                                          <th>التاريخ</th>
                                          <th>الاجراءات</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          @if (isset($products) && $products->count() > 0)
                                          @foreach ($products as $product)
                                          <tr>
                                          <td>{{$product->name}}</td>
                                          @isset($product->vendor)

                                          <td>{{$product->vendor->name}}</td>
                                          @endisset
                                          @if(!$product->vendor)
                                          <td>unknown</td>
                                          @endif
                                            @if (isset($product->category))
                                          <td>{{$product->category->name}}</td>
                                            @endif
                                            @if($product->active === 1 ? $active = 'مفعل' : $active = 'غيرمفعل')
                                            <td>{{$active}}</td>
                                        @endif

                                          <td><img style="width: 50px;height:50px" src="{{$product->photo}}" alt=""></td>
                                          <td>{{$product->created_at}}</td>
                                          <td>
                                            <div class="btn-group" role="group"
                                                 aria-label="Basic example">
                                                <a href="{{route('admin.product.edit',$product->id)}}"
                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                <a href="{{route('admin.product.destroy',$product->id)}}"
                                                   class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>
                                                <a href="{{route('admin.product.activation',$product->id)}}"
                                                   class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">
                                                   @if($product->active == 1)
                                                       إلغاء التفعيل

                                                       @else
                                                           تفعيل
                                                           @endif
                                                </a>
                                            </div>
                                        </td>
                                          </tr>
                                          @endforeach
                                          @endif
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                            <th>اسم المنتج</th>
                                            <th>اسم التاجر</th>
                                            <th>القسم</th>
                                            <th>التفعيل</th>
                                            <th>صورة المنتج</th>

                                            <th>الاجراءات</th>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>
                              </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
