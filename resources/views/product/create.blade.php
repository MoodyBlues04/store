@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="/product" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row mb-3">

                    <h2> Add new product </h2>

                    <div class="pt-2">
                        <label for="name" class="col-md-4 col-form-label">{{ __('name') }}</label>
    
                        <input id="name"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            required
                            >
        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="pt-2">
                        <label for="price" class="col-md-4 col-form-label">{{ __('price') }}</label>
    
                        <input id="price"
                        type="text"
                        class="form-control @error('price') is-invalid @enderror"
                        name="price"
                        required
                        >
                        
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="amount" class="col-md-4 col-form-label">{{ __('amount') }}</label>
                        
                        <input id="amount"
                        type="text"
                        class="form-control @error('amount') is-invalid @enderror"
                        name="amount"
                        required
                        >
                        
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="pt-2">
                        <label for="description" class="col-md-4 col-form-label">{{ __('description') }}</label>
    
                        <textarea id="description"
                            type="text"
                            class="form-control @error('description') is-invalid @enderror"
                            name="description"
                            rows="4"
                        > </textarea>
        
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="characteristics" class="col-md-4 col-form-label">{{ __('characteristics') }}</label>
    
                        <textarea id="characteristics"
                            type="text"
                            class="form-control @error('characteristics') is-invalid @enderror"
                            name="characteristics"
                            rows="4"
                        > </textarea>
        
                        @error('characteristics')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="pt-2">
                        <label for="image" class="col-md-4 col-form-label">{{ __('Add preview') }}</label>

                        <input id="image"
                            type="file"
                            class="form-control-file"
                            name="image"
                            required
                            >

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="photos[]" class="col-md-4 col-form-label">{{ __('Add product photos') }}</label>

                        <input id="photos[]"
                            type="file"
                            class="form-control-file"
                            name="photos[]"
                            multiple
                            required
                            >

                        @error('photos[]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-3">
                        <button class="btn btn-primary"> Add new product </button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
   
</div>
@endsection