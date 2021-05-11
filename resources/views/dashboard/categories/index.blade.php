@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li class="active"><i class="fa fa-category"></i> @lang('site.categories') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom:15px;">
                        @lang('site.categories')
                    </h3>
                    <form action="{{route('dashboard.categories.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                                       value="{{request()->search}}">
                            </div>


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary "><i
                                        class="fa fa-search"></i>@lang('site.search')</button>
                                @permission('categories-create')
                                <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>@lang('site.create')</a>
                                @endpermission

                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if($categories->count() > 0)
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.product_count')</th>
                                <th>@lang('site.product_related')</th>

                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->products->count()}}</td>
                                    <td><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}" class="btn btn-info btn-sm"> @lang('site.product_related')</a></td>

                                    <td>
                                        @permission('categories-update')

                                        <a href="{{route('dashboard.categories.edit',$category->id)}}"
                                           class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')
                                        </a>


                                        @endpermission
                                        @permission('categories-delete')

                                        <form action="{{route('dashboard.categories.destroy',$category->id)}}"
                                              method="post" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i
                                                    class="fa fa-trash"></i>@lang('site.delete')</button>
                                        </form>
                                        @endpermission


                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        {{ $categories->appends(request()->query())->links() }}


                    @else
                        <h2> @lang('site.no_data_found')</h2>
                    @endif
                </div>

            </div>
        </section>

    </div>
@endsection
