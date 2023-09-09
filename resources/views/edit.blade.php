@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3 ">
                <div class="my-3">
                    <a href="{{ route('post#update', $post['id']) }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-arrow-left-long mx-1"></i>back</a>
                </div>
                <form action="{{ route('post#update') }}" method="POST">
                    @csrf
                    <label for="">Post Title</label>
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <input type="text" name="postTitle"
                        class="form-control my-3 @error('postTitle') is-invalid @enderror"
                        value="{{ old('postTitle', $post['title']) }}" placeholder="Enter post title">
                    @error('postTitle')
                        <div class="invalid-feedback mb-3">{{ $message }}</div>
                    @enderror

                    <label for="">Post Description</label>
                    <textarea name="postDescription" id="" cols="30" rows="10"
                        class="form-control my-3 @error('postDescription') is-invalid  @enderror" placeholder="Enter Post Description">{{ old('postDescription', $post['description']) }}</textarea>
                    @error('postDescription')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <label for="">Price</label>
                    <input type="number" name="postPrice"
                        class="form-control my-3 @error('postPrice') is-invalid @enderror"
                        value="{{ old('postPrice', $post['price']) }}">
                        @error('postPrice')
                        <div class="invalid-feedback mb-3">{{ $message }}</div>
                        @enderror

                        <label for="">Address</label>
                        <input type="text" name="postAddress"
                            class="form-control my-3 @error('postAddress') is-invalid @enderror"
                            value="{{ old('postAddress', $post['address']) }}">
                            @error('postAddress')
                            <div class="invalid-feedback mb-3">{{ $message }}</div>
                            @enderror

                            <label for="">Rating</label>
                            <input type="number" name="postRating"
                                class="form-control my-3 @error('postRating') is-invalid @enderror"
                                value="{{ old('postRating', $post['rating']) }}">
                                @error('postRating')
                                <div class="invalid-feedback mb-3">{{ $message }}</div>
                                @enderror
                    <input type="submit" value="Save" class="btn btn-dark my-3 float-end">
                </form>
            </div>
        </div>
    </div>
@endsection
