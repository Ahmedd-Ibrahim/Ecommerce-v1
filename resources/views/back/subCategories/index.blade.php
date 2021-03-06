@extends('back.include.layout')
@section('content')
    ﻿ <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> اللغات </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> اللغات
                                </li>
                            </ol>
                        </div>
                    </div>
                    <a class="btn btn-info" href="{{route('admin.subCategories.create')}}">     أضافة قسم </a>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع لغات الموقع </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
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
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal ">
                                            <thead>
                                            <tr>
                                                <th> أسم القسم</th>
                                                <th>ينتمي إلي</th>
                                                <th>الصورة</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($sub_categories)
                                                @if(count($sub_categories) > 0)
                                                    @foreach($sub_categories as $category)
                                            <tr>
                                                <td>{{$category->name}}</td>
                                                <td>{{$category->translation_lang}}</td>
                                                <td><img style="width: 100px; height: 100px" src="{{$category->photo}}"></td>
                                                @if($category->active === 1 ? $active = 'مفعل' : $active = 'غيرمفعل')
                                                    <td>{{$active}}</td>
                                                @endif

                                                <td>
                                                    <div class="btn-group" role="group"
                                                         aria-label="Basic example">
                                                        <a href="{{route('admin.subCategories.edit',$category->id)}}"
                                                           class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                        <a href="{{route('admin.subCategories.destroy',$category->id)}}"
                                                           class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>
                                                        <a href="{{route('admin.subCategories.activation',$category->id)}}"
                                                           class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">
                                                           @if($category->active == 1)
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
                                                @endisset
                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">
                                        </div>
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
