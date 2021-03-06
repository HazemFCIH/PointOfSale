@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li class="active"><i class="fa fa-user"></i> @lang('site.users') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom:15px;">
                        @lang('site.users')
                    </h3>
                    <form action="{{route('dashboard.users.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                            </div>


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i>@lang('site.search')</button>
                                @permission('users-create')
                                <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</a>
                                @endpermission

                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if($users->count() > 0)
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td><img src="{{$user->image_path}}" width="70px" class="img-thumbnail" alt=""></td>
                                <td>
                                    @if(!$user->hasRole('super_admin'))
                                    @permission('users-update')

                                    <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</a>


                                    @endpermission
                                    @permission('users-delete')

                                    <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete btn-sm" ><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    </form>
                                        @endpermission
                                    @else
                                        @if(auth()->user()->hasRole('super_admin'))
                                        @permission('users-update')

                                        <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-primary btn-sm" ><i class="fa fa-edit "></i>@lang('site.edit')</a>
                                        @endpermission
                                        @endif

                                    @endif


                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                        {{ $users->appends(request()->query())->links() }}


                    @else
                        <h2> @lang('site.no_data_found')</h2>
                    @endif
                </div>

            </div>
        </section>

    </div>
@endsection
