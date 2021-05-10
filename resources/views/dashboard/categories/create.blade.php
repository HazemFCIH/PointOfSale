@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li><a href="{{route('dashboard.categories.index')}}"><i class="fa fa-user"></i> @lang('site.categories') </a>  </li>
                <li class="active"><i class="fa fa-user"></i> @lang('site.create') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @lang('site.categories')
                    </h3>
                </div>
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.categories.store')}}" method="post" >
                        @method('POST')
                        @csrf
                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label> @lang('site.'.$locale.'.name')</label>
                            <input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale.'name')}}">
                        </div>
                        @endforeach

                        <div class="form_group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection
