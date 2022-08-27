@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 offset-2">
            <div class="row">
                <div class="col-9">
                    <h1>{{$product->name}}</h1>
                    <img src="/storage/{{$product->image}}" alt="">

                    @if (isset($product->productPhotos))
                        <div>
                            @foreach ($product->productPhotos as $photo)
                                <img src="/storage/{{$photo->path}}" alt="photo">
                            @endforeach
                        </div>                        
                    @endif
                    
                </div>

                <div class="col-3">

                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection