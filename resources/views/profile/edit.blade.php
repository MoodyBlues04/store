@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="/profile" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row mb-3">

                    <h2> Edit your profile </h2>

                    <div class="pt-2">
                        <label for="username" class="col-md-4 col-form-label">{{ __('username') }}</label>
    
                        <input id="username"
                            type="text"
                            class="form-control @error('username') is-invalid @enderror"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username">
        
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="introduction" class="col-md-4 col-form-label">{{ __('introduction') }}</label>
    
                        <input id="introduction"
                            type="text"
                            class="form-control @error('introduction') is-invalid @enderror"
                            name="introduction"
                            value="{{ old('introduction') }}"
                            required
                            autocomplete="introduction">
        
                        @error('introduction')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="image" class="col-md-4 col-form-label">{{ __('image') }}</label>

                        <input id="image"
                            type="file"
                            class="form-control-file"
                            name="image"
                            value="{{ old('image') }}"
                            required
                            autocomplete="image">

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button class="btn btn-primary"> Save changes </button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
   
</div>
@endsection