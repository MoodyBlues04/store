@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 offset-2">
            
            <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                <h1>{{$product->name}}</h1>
                <div class="d-flex justify-content-between" style="width: 180px">
                    <div class="ml-5"><h2>{{$product->price . "p."}}</h2></div>
                    <div><h2>{{$product->amount . "шт."}}</h2>   </div>
                </div>    
            </div>
            
            <div class="row">
                <div class="col-8">
                    @if (isset($product->productPhotos))
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                    $i = 0;
                                    foreach ($product->productPhotos as $photo) {
                                        if ($i === 0) {
                                            echo "<div class='carousel-item active'>";
                                        } else {
                                            echo "<div class='carousel-item'>";
                                        }
                                        echo "<img
                                            src='/storage/$photo->path'
                                            alt='photo'
                                            class='d-block w-100'
                                            >
                                        </div>";
                                        $i++;
                                    }
                                ?>
                            </div>

                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    @endif
                    
                    @if (isset($product->description))
                        <div class="pt-4">
                            <h2>Description</h2>
                            <p>{{$product->description}}</p>
                        </div>
                    @endif
                    
                    @if (isset($product->characteristics))
                        <div>
                            <h2>Characteristics</h2>
                            <p>{{$product->characteristics}}</p>
                        </div>
                    @endif
                </div>

                <div class="col-4">
                    <div class="w-100 d-flex flex-column"
                        style="background-color: rgb(231, 231, 231); border-radius: 5px">

                        <a href="/profile/{{$product->user->id}}" style="text-decoration:none; color: black">
                            <div class="d-flex w-100 justify-content-around align-items-center mb-4 mt-3">
                                <div>
                                    <h2>{{$product->user->name}}</h2>
                                    @can('update', $product)
                                        <div>
                                            <a href="/product/{{$product->id}}/edit">Edit product</a>
                                        </div>
                                    @endcan 
                                    @can('delete', $product)
                                        <div>
                                            <a
                                                href="{{ route('product.destroy', ['product' => $product]) }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $product->id }}').submit();">
                                                Delete product
                                            </a>

                                            <form id="delete-form-{{ $product->id }}" action="{{ route('product.destroy', ['product' => $product]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method("DELETE")
                                            </form>
                                        </div>
                                    @endcan 
                                </div>
                                
                                <img
                                    class="rounded-circle"
                                    style="width: 35%"
                                    src={{ $product->user->profile->getImage() }}
                                    alt="image.png"
                                >
                            </div>
                        </a>

                        <a href={{ Auth::check() ? "#" : "/login" }}
                            class="btn btn-success w-100 d-flex flex-column justify-content-between align-items-center">
                            <h3 class="mt-2">Phone</h3>
                            @if (Auth::check())
                                <h5>{{$product->user->phone}}</h5>
                            @else
                                <h5>{{ substr($product->user->phone, 0, 4) . "-XXX-XX-XX" }}</h5>
                            @endif
                        </a>                      
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection