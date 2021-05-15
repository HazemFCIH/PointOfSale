@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">

                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-client"></i> @lang('site.clients')
                    </a></li>
                <li class="active"><i class="fa fa-client"></i> @lang('site.order_add') </li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">@lang('site.categories')</h3>
                        </div>{{-- end of box header --}}
                        <div class="box-body">
                            @foreach($categories as $category)
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse"
                                                   href="#{{str_replace(array(' ',','),array('-','-'),$category->name)}}">{{$category->name}}</a>
                                            </h4>
                                        </div>
                                        <div id="{{str_replace(array(' ',','),array('-','-'),$category->name)}}"
                                             class="panel-collapse collapse">
                                            <div class="panel-body">
                                                @if($category->products->count() > 0)
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th>@lang('site.name')</th>
                                                            <th>@lang('site.stock')</th>
                                                            <th>@lang('site.price')</th>
                                                            <th>@lang('site.add')</th>
                                                        </tr>
                                                        @foreach($category->products as $product)

                                                            <tr>
                                                                <td>{{$product->name}}</td>
                                                                <td>{{$product->stock}}</td>
                                                                <td>{{$product->sale_price}}</td>
                                                                <td><a href=""
                                                                       id="product-{{$product->id}}"
                                                                       data-name="{{$product->name}}"
                                                                       data-id="{{$product->id}}"
                                                                       data-price="{{$product->sale_price}}"
                                                                       class="btn {{in_array($product->id,$order->products->pluck('id')->toArray()) ? 'btn-default disabled' :'btn-success add-product-btn'}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a></td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @else
                                                    <p>@lang('site.no_records')</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>{{-- end of box body --}}
                    </div>
                </div>{{-- end of col-md-6 --}}
                <div class="col-md-6">
                    <div class="box box-primary">

                        <div class="box-header">

                            <h3 class="box-title">@lang('site.orders')</h3>

                        </div><!-- end of box header -->

                        <div class="box-body">

                            <form action="{{ route('dashboard.clients.orders.update', [$client->id,$order->id]) }}"
                                  method="post">

                                @csrf
                                @method('PUT')

                                @include('partials._errors')

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('site.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.price')</th>
                                    </tr>
                                    </thead>

                                    <tbody class="order-list">
                                    @foreach($order->products as $product)

                                        <tr>
                                            <td>{{$product->name}}</td>
                                            <td><input type="number" name="products[{{$product->id}}][quantity]"
                                                       data-price="{{$product->sale_price}}"
                                                       class="form-control input-sm product-quantity" min="1" value="{{$product->pivot->quantity}}">
                                            </td>
                                            <td class="product-price">{{number_format($product->sale_price * $product->pivot->quantity,2)}}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm remove-product-btn"
                                                        data-id="{{$product->id}}"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>

                                </table><!-- end of table -->

                                <h4>@lang('site.total') : <span class="total-price">{{$order->total_price}}</span></h4>

                                <button class="btn btn-primary btn-block" id="add-order-form-btn"><i
                                        class="fa fa-plus"></i> @lang('site.order_edit')</button>

                            </form>

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div>{{-- end of col-md-6 --}}
            </div> {{-- end of row--}}
        </section>

    </div>
@endsection
