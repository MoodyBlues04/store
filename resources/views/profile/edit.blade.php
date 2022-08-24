@extends('layouts.app')

@section('content')
<div class="container">
    <form method="post" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
        @csrf
        <div class="image">
            <label><h4>Edit your profile</h4></label>
            <input type="file" class="form-control" required name="image">
        </div>

        <div class="post_button">
            <button type="submit" class="btn btn-success">Edit</button>
        </div>
    </form>
</div>
@endsection