@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.orders')</h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>

                <li class="active"><i class="fa fa-order"></i> @lang('site.orders') </li>
            </ol>
        </section>
        <section class="content">
            <div class="row">

                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="margin-bottom:15px;">
                                @lang('site.orders')
                            </h3>
                            <form action="{{route('dashboard.orders.index')}}" method="get">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control"
                                               placeholder="@lang('site.search')"
                                               value="{{request()->search}}">
                                    </div>


                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary "><i
                                                class="fa fa-search"></i>@lang('site.search')</button>
                                        @permission('orders-create')
                                        <a href="{{route('dashboard.orders.create')}}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.create')</a>
                                        @endpermission

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body">
                            @if($orders->count() > 0)
                                <table class="table table-hover">

                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.client_name')</th>
                                        <th>@lang('site.price')</th>
                                        <th>@lang('site.order_status')</th>
                                        <th>@lang('site.show_products')</th>
                                        <th>@lang('site.created_at')</th>

                                        <th>@lang('site.action')</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$order->client->name}}</td>
                                            <td>{{number_format($order->total_price)}}</td>
                                            <td>@lang('site.status')</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm order-products"
                                                        data-url="{{route('dashboard.orders.show',$order->id)}}"
                                                        data-method="get"><i
                                                        class="fa fa-list"></i>@lang('site.show_products')
                                                </button>

                                            </td>
                                            <td>{{\Carbon\Carbon::createFromTimeStamp(strtotime($order->created_at))->diffForHumans()}}</td>

                                            <td>
                                                @permission('orders-update')

                                                <a href="{{route('dashboard.clients.orders.edit',[$order->client->id,$order->id])}}"
                                                   class="btn btn-primary btn-sm"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')
                                                </a>


                                                @endpermission
                                                @permission('orders-delete')

                                                <form action="{{route('dashboard.orders.destroy',$order->id)}}"
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
                                {{ $orders->appends(request()->query())->links() }}


                            @else
                                <h2> @lang('site.no_data_found')</h2>
                            @endif
                        </div>

                    </div>
                </div><!-- end of col -->
                <div class="col-md-4">
                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title" style="margin-bottom: 10px">@lang('site.show_products')</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                <div class="loader"></div>
                                <p style="margin-top: 10px">@lang('site.loading')</p>
                            </div>

                            <div id="order-product-list">

                            </div><!-- end of order product list -->

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div><!-- end of col -->
            </div><!-- end of row -->
        </section>

    </div>
@endsection
