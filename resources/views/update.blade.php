@extends('master')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3 ">
                <div class="my-3">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-arrow-left-long mx-1"></i>back</a>
                </div>
                <h3>{{ $post->title }}</h3>
                <p class="text-muted">
                    {{ $post->description }}
                </p>
                <div class="row">
                    <div class="col-12">
                        <p>{{$post->created_at->format('j-F-Y|n:i:A')}}</p>
                    </div>
                    <div class="col">
                        <div class="d-flex gap-3 ">
                            <div class=""><i class="fa-solid fa-money-check-dollar text-success"></i> {{ $post->price }}</div>
                            <div class=""> <i class="fa-solid fa-location-dot text-danger "></i>{{$post->address}}</div>
                            <div class=""><i class="fa-solid fa-star text-warning"></i>{{$post->rating}}</div>
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
