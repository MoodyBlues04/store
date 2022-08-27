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
                        @foreach ($product->productPhotos as $photo)
                            <div class="mb-4">
                                <img
                                src="/storage/{{$photo->path}}"
                                alt="photo"
                                class="w-100"
                                >
                            </div>
                        @endforeach
                    @endif
                    
                    @if (isset($product->description))
                        <div>
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
                                <h2>{{$product->user->name}}</h2>
                                <img
                                    class="rounded-circle"
                                    style="width: 35%"
                                    src="/storage/<?php
                                        if (isset($user->profile->image)) {
                                            echo $user->profile->image;
                                        } else {
                                            echo 'images/default.jpg';
                                        }
                                    ?>"
                                    alt="image.png"
                                >
                            </div>
                        </a>
                       
                        <button class="btn btn-success w-100 d-flex flex-column justify-content-between align-items-center">
                            <h3 class="mt-2">Phone</h3>
                            <h5>{{$product->user->phone}}</h5>
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection