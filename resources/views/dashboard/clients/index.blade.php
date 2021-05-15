@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li class="active"><i class="fa fa-client"></i> @lang('site.clients') </li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom:15px;">
                        @lang('site.clients')
                    </h3>
                    <form action="{{route('dashboard.clients.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                            </div>


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i>@lang('site.search')</button>
                                @permission('clients-create')
                                <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</a>
                                @endpermission

                            </div>

                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if($clients->count() > 0)
                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.order_add')</th>
                                     <th>@lang('site.action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$client->name}}</td>
                                <td>
                                    <ul>@foreach($client->phone as $phone)
                                       <li> {{$phone}}</li>
                                    @endforeach</ul></td>
                                <td>{{$client->address}}</td>

                                <td>
                                    @permission('orders-create')
                                    <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-primary btn-sm">@lang('site.order_add')</a>
                                    @endpermission
                                </td>

                                <td>
                                    @permission('clients-update')

                                    <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</a>


                                    @endpermission
                                    @permission('clients-delete')

                                    <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete btn-sm" ><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    </form>
                                        @endpermission



                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                        {{ $clients->appends(request()->query())->links() }}


                    @else
                        <h2> @lang('site.no_data_found')</h2>
                    @endif
                </div>

            </div>
        </section>

    </div>
@endsection
