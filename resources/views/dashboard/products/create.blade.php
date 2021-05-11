@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li><a href="{{route('dashboard.products.index')}}"><i class="fa fa-product"></i> @lang('site.products') </a>  </li>
                <li class="active"><i class="fa fa-product"></i> @lang('site.create') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @lang('site.products')
                    </h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label> @lang('site.'.$locale.'.name')</label>
                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale.'name')}}">
                            </div>
                        @endforeach
                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label> @lang('site.'.$locale.'.description')</label>
                                <textarea  name="{{$locale}}[description]" class="form-control ckeditor" value="{{old($locale.'description')}}"></textarea>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label> @lang('site.categories')</label>
                            <select name="category_id" class="form-control">
                                <option value="">--@lang('site.categories')</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label> @lang('site.purchase-price')</label>
                            <input type="number" name="purchase_price" class="form-control" value="{{old('purchase_price')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.sale-price')</label>
                            <input type="number" name="sale_price" class="form-control" value="{{old('sale_price')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{old('stock')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.image')</label>
                            <input type="file" name="image" class="form-control image-preview" >
                        </div>
                        <div class="form-group">
                            <img src="{{asset('uploads/product_images/productDefault.png')}}" style="width: 100px" class="img-thumbnail show-image">
                        </div>

                        <div class="form_group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection
