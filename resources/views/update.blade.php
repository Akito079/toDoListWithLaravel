@extends('master')
@section('content')
    <div class="container ">
        <div class="row mt-5">
            <div class="col-6 offset-3 ">
                <div class="my-3">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-arrow-left-long mx-1"></i>back</a>
                </div>
                <div class="">
                    <h3>{{ $post->title }}</h3>
                    <div class="">
                        <img class="img-thumbnail d-block mx-auto shadow-sm my-4"
                            src="@if ($post->image == null) {{ asset('storage/image-not-found-1-scaled-1150x647.png') }}
                    @else
                    {{ asset('storage/' . $post->image) }} @endif"
                            alt="">
                    </div>
                    <p class="text-muted">
                        {{ $post->description }}
                    </p>
                </div>
                <div class="row">
                    <div class="col-12 flex ">
                        <i class="fa-regular fa-calendar-days text-primary"></i>
                        <span>{{ $post->created_at->format('j-F-Y') }}</span>
                    </div>
                    <div class="col-12 flex my-3">
                        <i class="fa-solid fa-clock"></i>
                        <span>{{ $post->created_at->format('n:i:A') }}</span>
                    </div>
                    <div class="col">
                        <div class="d-flex gap-3 ">
                            <div class=""><i class="fa-solid fa-money-check-dollar text-success"></i>
                                {{ $post->price }} Kyats</div>
                            <div class=""> <i class="fa-solid fa-location-dot text-danger "></i>{{ $post->address }}
                            </div>
                            <div class=""><i class="fa-solid fa-star text-warning"></i>{{ $post->rating }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-3 offset-8">
                <a href="{{ route('post#editPage', $post['id']) }}">
                    <button class="btn bg bg-dark text-white">Edit</button>
                </a>
            </div>
        </div>
    </div>
@endsection
