@extends('back.include.layout')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> الاقسام الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة قسم رئيسي
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> تعديل قسم رئيسي </h4>
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
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.subCategories.update',$SubCategory->id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$SubCategory->id}}">
                                            <input type="hidden" name="cat_id" value="{{$SubCategory->id}}">
                                            <div class="form-group text-center">
                                                <img src="{{$SubCategory->photo}}" style="height:400px; width: 500px">
                                            </div>
                                            <div class="form-group">
                                                <label> تحديث صورة القسم </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم القسم - {{__('messages.'.$SubCategory-> translation_lang)}} </label>
                                                                    <input type="text" value="{{$SubCategory->name}}" id="name"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="name">
                                                                    @error("name")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 hidden">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> أختصار اللغة {{__('messages.'.$SubCategory-> translation_lang)}} </label>
                                                                    <input type="text" id="abbr"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{$SubCategory-> translation_lang}}"
                                                                           name="abbr">

                                                                    @error("abbr")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="active"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           @if($SubCategory->active == 1) checked @endif
                                                                           />
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">الحالة  {{__('messages.'.$SubCategory-> translation_lang)}} </label>

                                                                    @error("category.0.active")
                                                                    <span class="text-danger"> </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                            </div>

                                            {{-- <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div> --}}
                                        {{-- </form> --}}
                                    <h3 class="text-center"> <i class="ft-home"></i>تعديل بيانات القسم فى اللغات الاخري</h3>

                                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified" id="tab-top-line-drag">
                                            @isset($SubCategory->mainLang)
                                                @foreach($SubCategory->mainLang as $index => $trans)
                                            <li class="nav-item">
                                                <a class="nav-link @if($index == 0) active @endif" id="activeIcon1-tab1" data-toggle="tab" href="#activeIcon1{{$index}}"
                                                   aria-controls="activeIcon1" aria-expanded="true"><i class="la la-check"></i> {{$trans->translation_lang}}</a>
                                            </li>
                                                @endforeach
                                            @endisset
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                        @isset($SubCategory->mainLang)
                                            @foreach($SubCategory->mainLang as $index => $trans)

                                            <div role="tabpanel" class="tab-pane @if($index == 0) active @endif" id="activeIcon1{{$index}}" aria-labelledby="activeIcon1-tab1"
                                                 aria-expanded="false">
                                                {{-- <form class="form" action="{{route('admin.subCategories.update',$trans->id)}}"
                                                      method="POST"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$trans->id}}"> --}}
                                                    <div class="form-body">
                                                        <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم القسم - {{__('messages.'.$trans -> translation_lang)}} </label>
                                                                    <input type="text" value="{{$trans->name}}" id="name"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           name="mainLang[{{$index}}][name]">
                                                                    @error("category.$index.name")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        <div class="col-md-6 hidden" ">
                                                        <input type="text" name="mainLang[{{$index}}][cat_id]" value="{{$trans->id}}">
                                                        </div>
                                                            <div class="col-md-6 hidden">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> أختصار اللغة {{__('messages.'.$trans -> translation_lang)}} </label>
                                                                    <input type="text" id="abbr"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{$trans -> translation_lang}}"
                                                                           name="mainLang[{{$index}}][abbr]">

                                                                    @error("mainLang.$index.abbr")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="mainLang[{{$index}}][active]"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           @if($trans->active == 1) checked @endif
                                                                    />
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">الحالة  {{__('messages.'.$trans -> translation_lang)}} </label>

                                                                    @error("mainLang.$index.active")
                                                                    <span class="text-danger"> </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button type="button" class="btn btn-warning mr-1"
                                                                onclick="history.back();">
                                                            <i class="ft-x"></i> تراجع
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> حفظ
                                                        </button>
                                                    </div>
                                                </form>
                                            </form>
                                            </div>

                                            @endforeach
                                        @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
