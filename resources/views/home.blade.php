@extends('app')
@section('content')
    <div class="container">
        <div style="font-size: 32px; color: #333333; text-align: center; margin-bottom: 15px;">{{ $message }}</div>
        @include('film-list')
    </div>
@endsection
