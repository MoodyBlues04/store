@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-10" style="margin: 30px auto">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-6 pb-4">
                        <a href="/product/{{$product->id}}" style="text-decoration:none; color:black">
                            <div class="card">
                                <img class="card-img-top" src="/storage/{{$product->image}}" alt="Card image cap">
                                <div class="card-body">
                                    <h2 class="card-title ">{{$product->name}}</h2>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-text mt-1 p-0"><strong>{{$product->price}}p.</strong></h5>
                                        <h5 class="card-text mt-1 p-0">{{$product->amount}}шт.</h5>
                                    </div>

                                    @if (isset($product->description))
                                        <div>
                                            <h5 class="mt-1 mb-3">Description</h5>
                                            <p class="card-text m-0 p-0">{{$product->description ?? "N/A"}}</p>
                                        </div>
                                    @endif
                                    
                                    @if (isset($product->characteristics))
                                        <div class="mt-2 mb-3">
                                            <h5 class="mt-1 mb-3">Characteristics</h5>
                                            <p class="card-text m-0 p-0">{{$product->characteristics ?? "N/A"}}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection