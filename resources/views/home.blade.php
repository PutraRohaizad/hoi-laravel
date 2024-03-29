@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<div class="container mt-2">
    <div class="row">
        <div class="col-md-7">
            <div>
                <form>
                    <input type="text" class="form-control" name="name" placeholder="Filter">
                    <div class="m-2">
                        <a href="/home" class="btn btn-sm btn-secondary">Reset</a>
                        <button class="btn btn-sm btn-primary">Search</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header bg-red-300 text-white font-bold">List of Product</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Price (RM)</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="border px-4 py-2">{{ $loop->index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $product->name }}</td>
                                <td class="border px-4 py-2">{{ $product->price }}</td>
                                <td class="border px-4 py-2">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#cartModal{{$product->id}}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @include('modal.info')
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert-warning p-3 text-center">No product can be found ...</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (count($orders) > 0)
            <div class="card mt-3">
                <div class="card-header bg-green-300 font-bold">Your Orders</div>
                <div class="card-body">
                    <table class="table-auto items-center">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Address</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Total Price(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="border px-4 py-2">{{$loop->index + 1}}</td>
                                <td class="border px-4 py-2">{{optional($order->product)->name}}</td>
                                <td class="border px-4 py-2">{{$order->address}}</td>
                                <td class="border px-4 py-2">{{$order->quantity}}</td>
                                <td class="border px-4 py-2">{{optional($order->product)->price * $order->quantity}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif


        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    My Cart
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2" nowrap>Total (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carts as $cart)
                            <tr>
                                <td class="border px-4 py-2">{{$loop->index + 1}}</td>
                                <td class="border px-4 py-2">{{$cart->product->name}}</td>
                                <td class="border px-4 py-2">{{$cart->quantity}}</td>
                                <td class="border px-4 py-2">{{$cart->product->price * $cart->quantity}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert-warning p-2 text-center">Your cart is empty :(</div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if ($carts->count() > 0)

                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                    @endif

                    <form action="{{route('checkout')}}" method="POST">
                        <div>
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}"
                                readonly>
                        </div>
                        <div>
                            <label for="name">Address</label>
                            <textarea name="address" id="address" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        @csrf
                        <br>
                        <button
                            class="btn btn-secondary">
                            Checkout and Pay
                        </button>
                        <a href="{{ route('clearCart') }}" class="btn btn-primary">Clear Cart</a>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    setTimeout(function(){
        document.querySelector('.alert').remove()
    }, 2000)
</script>