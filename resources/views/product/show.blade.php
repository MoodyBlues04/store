@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 offset-2">
            <div class="row">
                <div class="col-9">
                    <h1>{{$product->name}}</h1>

                    @if (isset($product->productPhotos))
                        @foreach ($product->productPhotos as $photo)
                            <div>
                                <img
                                src="/storage/{{$photo->path}}"
                                alt="photo"
                                class="w-100"
                                >
                            </div>
                        @endforeach
                    @endif
                    
                </div>

                <div class="col-3">

                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection