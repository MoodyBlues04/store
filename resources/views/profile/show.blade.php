@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row justify-content-center pt-4">
                <div class="col-3">
                    <img
                        class="w-100 rounded-circle"
                        src={{ $user->profile->getImage() }}
                        alt="image.png">
                </div>
                <div class="col-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1>{{ $user->profile->username ?? "Enter username" }}</h1>

                        {{-- vue component --}}
                        @if (Auth::check() && Auth::user()->id !== $user->id)
                            <rate-button
                                user-id="{{ $user->id }}"
                                value="{{ $value }}"
                                avg-value="{{ $avgValue }}"
                            ></rate-button>
                        @else
                            <div class="d-flex pt-1 justify-content-between align-items-center" style="width: 70px">
                                <div style="font-size: 105%">stars</div>
                                <div style="font-size: 120%">{{ $avgValue }}</div>
                            </div>
                        @endif
                        
                    </div>
                    
                    <div>
                        <h4>{{ $user->profile->introduction ?? "Enter introduction here" }}</h4>
                    </div>

                    <div class="d-flex justify-content-between" style="width: 75px">
                        <div class="mr-1">{{ $productsCount }}</div>
                        <div>products</div>
                    </div>
                    
                    <div class="d-flex flex-column">
                        @can('update', $user->profile)
                            <div>
                                <a href="/profile/{{$user->id}}/edit">Edit profile</a>
                            </div>
                            <div>
                                <a href="/product/create">Add new product</a>
                            </div>
                        @endcan
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8 mt-5">
            <div class="row justify-content-center">
                @if (isset($user->products))
                    @foreach ($user->products as $product)
                        <div class="col-4 pb-4">
                            <a href="/product/{{$product->id}}" style="text-decoration:none; color:black">
                                <div class="card">
                                    <img class="card-img-top" src="/storage/{{$product->image}}" alt="Card image cap">
                                    
                                    <div class="card-body">
                                        <h5 class="card-title m-0 p-0">{{$product->name}}</h5>
                                        
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text m-0 p-0"><strong>{{$product->price}}p.</strong></p>
                                            
                                            <p class="card-text m-0 p-0">{{$product->amount}}????.</p>
                                        </div>
                                        
                                        <p class="card-text m-0 p-0">
                                            @if (!isset($product->description))
                                                {{ "description unset" }}
                                            @elseif (mb_strlen($product->description, 'utf-8') > 50)
                                                {{ mb_substr($product->description, 0, 50) . '...' }}
                                            @else
                                                {{ $product->description }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection