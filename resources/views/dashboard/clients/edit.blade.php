@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-client"></i> @lang('site.clients') </a>  </li>
                <li class="active"><i class="fa fa-client"></i> @lang('site.edit') </li>
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
                    <form action="{{route('dashboard.clients.update',$client->id)}}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf


                        <div class="form-group">
                            <label> @lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{$client->name}}">
                        </div>
                        @foreach($client->phone as $phone)
                            <div class="form-group">
                                <label> @lang('site.phone')</label>
                                <input type="text" name="phone[]" class="form-control" value="{{$phone}}">
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label> @lang('site.address')</label>
                            <textarea name="address" class="form-control">{{$client->address}}</textarea>

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
