@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="/product/{{ $product->id }}" enctype="multipart/form-data" method="post">
                @csrf
                @method('PATCH')
                <div class="row mb-3">

                    <h2> Edit product </h2>

                    <div class="pt-2">
                        <label for="name" class="col-md-4 col-form-label">{{ __('name') }}</label>
    
                        <input id="name"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') ?? $product->name }}"
                            required>
        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="description" class="col-md-4 col-form-label">{{ __('description') }}</label>
    
                        <input id="description"
                            type="text"
                            class="form-control @error('description') is-invalid @enderror"
                            name="description"
                            value="{{ old('description') ?? $product->description }}"
                            >
        
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label for="characteristics" class="col-md-4 col-form-label">{{ __('characteristics') }}</label>
    
                        <input id="characteristics"
                            type="text"
                            class="form-control @error('characteristics') is-invalid @enderror"
                            name="characteristics"
                            value="{{ old('characteristics') ?? $product->characteristics }}"
                            >
        
                        @error('characteristics')
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
                            value="{{ old('price') ?? $product->price }}"
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
                            value="{{ old('amount') ?? $product->amount }}"
                            required
                            >
        
                        @error('amount')
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
                            >

                        @error('photos[]')
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