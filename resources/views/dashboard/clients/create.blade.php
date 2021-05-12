@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-client"></i> @lang('site.clients') </a>  </li>
                <li class="active"><i class="fa fa-client"></i> @lang('site.create') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @lang('site.clients')
                    </h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.clients.store')}}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="form-group">
                            <label> @lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        @for($i = 0; $i < 2; $i++)
                        <div class="form-group">
                            <label> @lang('site.phone')</label>
                            <input type="text" name="phone[]" class="form-control" value="">
                        </div>
                        @endfor

                        <div class="form-group">
                            <label> @lang('site.address')</label>
                            <textarea name="address" class="form-control">{{old('address')}}</textarea>

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
