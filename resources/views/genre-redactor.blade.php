@extends('app')

@section('content')
    <div class="container">
        <form action="@if(isset($genre)) {{ route("post-update-genre") }} @else {{ route("post-new-genre") }} @endif" method="post" class="creator" enctype="multipart/form-data">
            @csrf
            <h1>A new genre</h1>
            <div class="meta-field">
                @if(isset($genre))
                    <input type="hidden" name="id" value="{{ $genre->p_code }}">
                @else
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="text"  name="id">
                        <span>id</span>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="text" @if(isset($genre)) value="{{ $genre->title }}" @endif name="title">
                        <span>Title</span>
                    </div>
                </div>
                <button class="minimo-button" style="margin-top: 30px; width: 100%;">Done</button>
            </div>
        </form>
    </div>
@endsection
