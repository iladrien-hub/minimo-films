@extends("app")

@section("content")
    <style>
        .actor-info {
            display: flex;
            margin-bottom: 15px;
        }
        .actor-info .left-side {
            width: 30%;
        }
        .actor-info .right-side {
            width: 70%;
        }
        .actor-info .photo {
            width: 100%;
        }
        .actor-info .photo img {
            width: 100%;
        }
        .actor-info .about {
            padding: 30px;
        }
        .actor-info .name {
            font-size: 32px;
            color: #333333;
        }
        .actor-info .description {
            padding: 0;
        }
    </style>
    <div class="container">
        <div class="actor-info">
            <div class="left-side">
                <div class="photo">
                    <img src="{{ asset("storage/images/".$person->photo) }}" alt="{{ $person->name }}">
                </div>
            </div>
            <div class="right-side">
                <div class="about">
                    <div class="name">{{ $person->name }}</div>
                    <div class="description">{{ $person->description }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div style="font-size: 26px; color: #333333; margin-bottom: 10px; text-align: center;">
            Films
        </div>
    </div>
    <div class="container">
        @include('film-list')
    </div>
@endsection
