@extends("app")

@section("content")
    <style>
        .film-more-wrapper {
            display: flex;
        }
        .left-side {
            width: 30%;
            flex-grow: 1;
        }
        .right-side {
            width: 70%;
            flex-grow: 0;
        }
        .right-side-inner {
            padding: 30px;
        }
        .poster {
            width: 100%;
        }
        .poster img {
            width: 100%;
            object-fit: cover;
        }
        .title {
            font-size: 36px;
            margin-bottom: 15px;
            color: #333;
        }
        .genres {
            margin-bottom: 25px;
        }
        .description {
            color: #6e6e6e;
            font-family: Ubuntu, serif;
            margin-bottom: 30px;
        }
        .actors {
            padding: 15px;
            display: flex;
        }
        .person {
            width: 120px;
            margin: 5px;
        }
        .person .photo {
            width: 118px;
            height: 118px;
            overflow: hidden;
            border-radius: 50%;
            margin-bottom: 5px;
            border: 1px solid #333;
        }
        .person img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .person-name {
            font-size: 18px;
            text-align: center;
            width: 100%;
        }
        .role-name {
            font-size: 14px;
            text-align: center;
            font-family: 'Ubuntu', sans-serif !important;
            width: 100%;
            opacity: .9;
        }
        .sub-title {
            font-size: 20px;
        }
        .director {
            font-family: Ubuntu, serif;
            opacity: .8;
        }
    </style>

    <div class="container">
        <div class="film-more-wrapper">
            <div class="left-side">
                <div class="poster">
                    <img src="{{ asset("storage/images/".$film->poster) }}" alt="{{ $film->title }}">
                    @if(\App\Models\Film::isPurchased($film->id) == null)
                        <form action="{{ route("purchase", ["id" => $film->id]) }}" method="get">
                            <button class="minimo-button" style="margin-top: 30px; width: 100%;">
                                @if($film->price == 0)
                                    Get for free
                                @else
                                    Buy for {{ $film->price }} UAH
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="right-side">
                <div class="right-side-inner">
                    @if($film->director)
                        <span><a href="{{ route("page", ["id" => $film->director->id]) }}" class="director">{{ $film->director->name }}</a></span>
                    @endif
                    <div class="title">{{ $film->title }}</div>
                    <div class="genres">
                        @foreach($film->genres as $genre)
                            <span><a href="{{ \App\Models\Genre::getFilterRoute($genre->p_code) }}">{{ $genre->title }}</a></span>
                        @endforeach
                    </div>
                    <div class="description">{{ $film->description }}</div>
                    <div class="sub-title">Actors</div>
                    <div class="actors">
                        @foreach($film->actors as $actor)
                            <div class="person">
                                <div class="photo">
                                    <img src="{{ asset("storage/images/".$actor->photo) }}" alt="{{ $actor->name }}">
                                </div>
                                <div class="person-name"><a href="{{ route("page", ["id" => $actor->id]) }}">{{ $actor->name }}</a></div>
                                <div class="role-name"><a href="{{ route("page", ["id" => $actor->id]) }}">{{ $actor->role_name }}</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(\App\Models\Film::isPurchased($film->id))
        <div class="container">
            <style>
                .video-container {
                    position: relative;
                    width: 100%;
                    padding-bottom: 56.25%;
                }
                .video {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: 0;
                }
            </style>
            <div class="video-container">
                <iframe class="video" src="https://www.youtube.com/embed/{{ $film->video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    @endif
@endsection
