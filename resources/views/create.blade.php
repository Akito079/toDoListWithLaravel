@extends('master')
@section('content')
    <div class="container mt-5">
        <div class="row ">
            <div class="col-5">
                <div class="p-3">
                    <div class="alert-message">
                        @if (session('insertSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('insertSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('updateSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('updateSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                    </div>
                    <form action="{{ route('post#create') }}" method="POST">
                        @csrf
                        <div class="text-group mb-3">
                            <label for="" id="">Post Title</label>
                            <input type="text" name="postTitle" id="" value="{{ old('postTitle') }}"
                                class="form-control @error('postTitle') is-invalid @enderror"
                                placeholder="Enter Post Title....">

                            @error('postTitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="" id="">Post Description</label>
                            <textarea name="postDescription" class="form-control @error('postDescription')is-invalid @enderror" id=""
                                cols="30" rows="10" placeholder="Enter Post Description...">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Price</label>
                            <input class="form-control @error('postPrice') is-invalid @enderror" type="number"
                                name="postPrice" id="" placeholder="Enter your commission" value="{{old('postPrice')}}">
                            @error('postPrice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">Location</label>
                            <input type="text" class="form-control @error('postAddress') is-invalid @enderror"
                                name="postAddress" id="" placeholder="Enter the location" value="{{old('postAddress')}}">
                            @error('postAddress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="" id="">Rating</label>
                            <input type="number" name="postRating" id="" min="0" max="5"
                                class="form-control @error('postRating') is-invalid @enderror"placeholder="enter rating">
                            @error('postRating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Image</label>
                            <input type="file" class="form-control @error('postImage') is-invalid @enderror "
                                name="postImage" id="">
                                @error('postImage')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                        </div>

                        <div class="">
                            <input type="submit" value="Create" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7">
                <div class="data-container">
                    <h3 class="mb-3">
                        <div class="row">
                            <div class="col-5">Total - {{ $posts->total() }}</div>
                            <div class="offset-2 col-5">
                                <form action="{{ route('post#createPage') }}" method="get">
                                    <div class="row">
                                        <input type="text" name="searchKey" class="form-control col" id=""
                                            placeholder="Search posts" value="{{ request('searchKey') }}">
                                        <button type="submit" name="" class="btn btn-danger d-inline mx-2 col-2"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </h3>
                    @if(count($posts) != 0)
                        @foreach ($posts as $item)
                            <div class="post p-3 shadow-sm mb-4 ">
                                <div class="row">
                                    <h5 class="col-7">{{ $item->title }}</h5>
                                    <h5 class="col-4  offset-1 text-center">{{ $item->created_at->format('j-F-Y|n:i:A') }}
                                    </h5>
                                </div>
                                {{-- {{substr($item['title'],0,10)}} --}}
                                <p class="text-muted">
                                    {{-- cutting words with laravel method --}}
                                    {{ Str::words($item->description, 25, '....') }}
                                </p>
                                <span>
                                    <small>
                                        <i class="fa-solid fa-money-check-dollar text-success"></i>{{ $item->price }}Kyats
                                    </small>
                                </span>|
                                <span><i class="fa-solid fa-location-dot text-danger"></i>{{ $item->address }}</span>|

                                <span><i class="fa-solid fa-star text-warning"></i>{{ $item->rating }}</span>
                                <div class="text-end">
                                    <a href="{{ route('post#delete', $item->id) }}">
                                        <button class="btn btn-sm btn-danger"><i
                                                class="fa-solid fa-trash"></i>ဖျက်ပါ။</button>
                                    </a>
                                    {{-- <form action="{{route('post#delete',$item['id'])}} " method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>ဖျက်ပါ။</button>
                             </form> --}}
                                    <a href="{{ route('post#updatePage', $item->id) }}">
                                        <button class="btn btn-sm btn-primary"><i
                                                class="fa-solid fa-file-lines"></i>အပြည့်အစုံဖတ်ပါ</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="text-danger text-center mt-5">There is no data...</h3>
                    @endif
                    {{-- @for ($i = 0; $i < count($posts); $i++)
                    <div class="post p-3 shadow-sm mb-4 ">
                        <h5>{{$posts[$i][ 'title']}}</h5>
                        <p class="text-muted">
                            {{ $posts[$i]['description'] }}
                        </p>
                        <div class="text-end">
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            <button class="btn btn-sm btn-primary"><i class="fa-solid fa-file-lines"></i></button>
                        </div>
                    </div>
                    @endfor --}}
                </div>
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    @endsection
