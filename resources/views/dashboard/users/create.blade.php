@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-user"></i> @lang('site.users') </a>  </li>
                <li class="active"><i class="fa fa-user"></i> @lang('site.create') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @lang('site.users')
                    </h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label> @lang('site.first_name')</label>
                                <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.last_name')</label>
                                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label> @lang('site.image')</label>
                            <input type="file" name="image" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label> @lang('site.password')</label>
                            <input type="password" name="password" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label> @lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>

                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                @foreach($models as $model)
                                <li class="nav-item">
                                    <a class="nav-link {{$loop->first ? 'active' : ''}}" id="tab1" data-toggle="pill" href="#{{$model}}" role="tab" aria-controls="custom-content-below-home" aria-selected="true">

                                        @lang('site.'.$model)</a>
                                </li>
                                @endforeach


                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent">
                                @foreach($models as $model)

                                <div class="tab-pane {{$loop->first ? 'active' : ''}}" id="{{$model}}" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                @foreach($maps as $map)
                                        <label for="">
                                            <input type="checkbox" name="permissions[]" value="{{$model}}-{{$map}}" id="">
                                            @lang('site.'.$map)
                                        </label>
                                    @endforeach

                                </div>
                                @endforeach



                            </div>

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
