<style>
    .film-item {
        position: relative;
        margin-bottom: 15px;
    }
    .film-item .poster {
        width: 300px;
        height: 428px;
    }
    .film-item .poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .film-item .info {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%);
        background-color: rgba(51,51,51, .5);

        display: flex;
        justify-content: center;
        flex-direction: column;
        vertical-align: baseline;
        text-align: center;

        opacity: 0;
        transition: opacity ease .4s;
    }
    .film-item:hover .info {
        opacity: 1;
    }
    .info-inner {
        padding: 30px;
    }
    .film-row {
        display: flex;
        justify-content: space-around;
    }
    .film-item .info .title {
        color: #ffffff;
        font-size: 32px;
        margin-bottom: 10px;
        font-family: 'Playfair Display', serif;
    }
    .film-item .info .genres {
        display: flex;
        justify-content: center;
        padding: 0 15px;
        margin-bottom: 15px;
        font-size: 14px;
        opacity: .9;
    }
    .film-item .info .genre {
        background-color: #dedede;
        padding: 8px;
        font-family: 'Ubuntu', serif;
        border-radius: 5px;
        border: 1px solid #333;
        color: #333;
        margin: 0 5px;
    }
    .film-item .info .description {
        font-family: 'Ubuntu', serif;
        color: #ffffff;
    }
    .film-item .price {
        position: absolute;
        right: 15px;
        bottom: 10px;
        color: #ffffff;
        background: #f66d9b;
        padding: 5px 9px;
        font-family: 'Inconsolata', monospace;
        border: 1px solid #333;
        border-radius: 10px;
        cursor: default;
    }
</style>

<?php
    $counter = 0;
    if (!isset($films)) {
        $films = (new \App\Models\SearchFilm())->setOrderBy("title")->get();
    }
?>

@while($counter < sizeof($films))
<div class="film-row">
    @for($i = 0; $i < 3 && $counter < sizeof($films); $i++)
        <div class="film-item">
            <div class="poster">
                <img src="{{ asset("storage/images/".$films[$counter]->poster) }}" alt="fight-club">
            </div>
            <div class="info">
                <div class="info-inner">
                    <a href="{{ route("page", ["id" => $films[$counter]->id]) }}"><div class="title">{{ $films[$counter]->title }}</div></a>
                    <div class="genres">
                        @foreach($films[$counter]->genres as $genre)
                            <a href="{{ \App\Models\Genre::getFilterRoute($genre->p_code) }}" class="genre">{{ $genre->title }}</a>
                        @endforeach
                    </div>
                    <a href="{{ route("page", ["id" => $films[$counter]->id]) }}">
                        <div class="description">{{ mb_strimwidth($films[$counter]->description, 0, 310, "...") }}</div>
                    </a>
                </div>
            </div>
            <div class="price">
                @if($films[$counter]->price == 0)
                    Free
                @else
                    {{ $films[$counter]->price }} UAH
                @endif
            </div>
        </div>
        <?php
            $counter += 1;
        ?>
    @endfor
</div>
@endwhile
