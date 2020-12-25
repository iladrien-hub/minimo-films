@extends("app")

@section("content")
    <style>
        .minimo-multiselect .title{
            color: #333333;
            margin-bottom: 5px;
        }
        .minimo-multiselect .select {
            border: 1px solid #333333;
            height: 130px;
            overflow-y: scroll;
        }
        .minimo-multiselect .option {
            padding: 3px 10px;
            font-size: 14px;
            cursor: pointer;
        }
        .minimo-multiselect .option.marked {
            background-color: #6cb2eb;
        }
        .search-filters {
            display: flex;
            width: 100%;
        }
        .search-filters div {
            flex-grow: 1;
        }
        .search-filters .minimo-multiselect {
            margin-left: 5px;
        }
        .search-filters .row:first-child .minimo-multiselect {
            margin-left: 0;
        }
        .search-buttons {
            display: flex;
        }
        .search-buttons .minimo-button {
            margin-top: 30px;
            width: 50%;
            flex-grow: 1;
            margin-right: 5px;
            height: 100%;
        }
        .search-buttons .minimo-button:last-child {
            margin-right: 0;
        }
    </style>
    <div class="container" style="margin-bottom: 40px">
        <div style="width: 60%; margin: 0 auto; border: 1px solid #333; padding: 15px;">
            <form action="{{ route("search") }}" method="get" class="creator">
                <h1>Search</h1>
                <div class="minimo-text-input">
                    <input type="text" @isset($title) value="{{ $title }}" @endif name="title">
                    <span>Title</span>
                </div>
                <div class="search-filters">
                    <div class="row">
                        <div class="minimo-multiselect" name="genres">
                            <div class="title">Choose genres</div>
                            <div class="select">
                                @foreach(\App\Models\Genre::getAllGenres() as $genre)
                                    <div class="option @if(in_array($genre->p_code, $genres)) marked @endif" val="{{ $genre->p_code }}" class="marked">{{ $genre->title }}</div>
                                @endforeach
                            </div>
                            <div class="marked-wrapper"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="minimo-multiselect" name="persons">
                            <div class="title">Choose persons</div>
                            <div class="select">
                                @foreach(\Illuminate\Support\Facades\DB::table("person")->get() as $person)
                                    <div class="option @if(in_array($person->id, $persons)) marked @endif" val="{{ $person->id }}" class="marked">{{ $person->name }}</div>
                                @endforeach
                            </div>
                            <div class="marked-wrapper"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="search-buttons">
                        <button class="minimo-button" style="margin-top: 30px; width: 100%;">Search</button>
                        <a href="{{ route("search") }}" class="minimo-button">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(".minimo-multiselect .option").click(function (){
            $(this).toggleClass("marked");
            completeMultiSelect();
        })
        function completeMultiSelect() {
            $(".minimo-multiselect").each(function () {
                const $thisRef = $(this);
                const $wrapper = $thisRef.find(".marked-wrapper");
                const $name = $thisRef.attr("name") + "[]";
                $wrapper.html("");
                $thisRef.find(".marked").each(function () {
                    $wrapper.append($(`<input type="text" hidden value="${$(this).attr("val")}" name="${$name}">`))
                })
            })
        }
        completeMultiSelect();
    </script>
    <div class="container">
        <div style="font-size: 24px; color: #333333; text-align: center; margin-bottom: 15px;">Found {{ sizeof($films) }} result(s)</div>
        @include("film-list")
    </div>
@endsection
