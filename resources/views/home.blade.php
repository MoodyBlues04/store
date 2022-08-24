@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="row justify-content-center pt-4">
                <div class="col-3">
                    <img class="w-100 rounded-circle" src="{{ asset('storage') . '/images/cat.jpg' }}" alt="image.png">
                </div>
                <div class="col-9">
                    <div>
                        <h1>{{ $user->profile->username ?? "Enter username" }}</h1>
                    </div>
                    <div>
                        <h4>{{ $user->profile->introduction ?? "Enter introduction here" }}</h4>
                    </div>
                    <div>
                        <a href="profile/{{$user->id}}/edit">Edit profile</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8 mt-5">
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top" style="height: 100px" src="{{ asset('storage') . '/images/cat.jpg' }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title m-0 p-0">Card title</h5>
                            <p class="card-text m-0 p-0"><strong>price.</strong></p>
                            <p class="card-text m-0 p-0">introduction.</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top" style="height: 100px" src="{{ asset('storage') . '/images/cat.jpg' }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title m-0 p-0">Card title</h5>
                            <p class="card-text m-0 p-0"><strong>price.</strong></p>
                            <p class="card-text m-0 p-0">introduction.</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top" style="height: 100px" src="{{ asset('storage') . '/images/cat.jpg' }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title m-0 p-0">Card title</h5>
                            <p class="card-text m-0 p-0"><strong>price.</strong></p>
                            <p class="card-text m-0 p-0">introduction.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection