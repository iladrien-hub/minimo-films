@extends('app')

@section('content')

    <style>
        .minimo-multiselect {
            width: 100%;
            padding-bottom: 20px;
        }
        .minimo-multiselect .select {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }
        .minimo-multiselect .option {
            margin-right: 20px;
            margin-bottom: 10px;
            cursor: pointer;
            background-color: #fff;
            border-radius: 45px;
            border: 2px solid #333;
            padding: 10px 20px;
        }
        .minimo-multiselect .option.marked {
            color: #90c2f8;
            border: 2px solid #90c2f8;
            background-color: #333;
        }
        .minimo-multiselect .title {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .minimo-actor-select {
            margin-top: 15px;
            width: 100%;
            align-items: center;
        }
        .minimo-actor-select select {
            margin-right: 15px;
        }
        .minimo-actor-select i {
            margin-left: 5px;
            font-size: 22px;
            cursor: pointer;
        }
        .minimo-actor-select .title i {
            font-size: 18px;
        }
    </style>

    <div class="container">
        <form action="@isset($film) {{ route("post-update-film") }} @else {{ route("post-new-film") }} @endif" method="post" class="creator" enctype="multipart/form-data">
            @csrf
            <h1>@isset($film) {{ $film->title }} @else A new film @endif</h1>
            <div class="meta-field">
                @isset($film)
                    <input type="hidden" name="id" value="{{ $film->id }}">
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
                        <input required type="text" @isset($film) value="{{ $film->title }}" @endif name="title">
                        <span>Title</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="number" min="0" @isset($film) value="{{ $film->price }}" @endif name="price">
                        <span>Price</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <textarea required type="textarea" rows="3" name="description">@isset($film){{ $film->description }}@endif</textarea>
                        <span>Description</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="text" @isset($film) value="{{ $film->video }}" @endif name="video">
                        <span>Video</span>
                    </div>
                </div>
                <?php
                    $all_persons = \Illuminate\Support\Facades\DB::table("person")->get();
                ?>
                <div class="row">
                    <div style="margin-top: 10px">
                        <div class="title">Director</div>
                        <select name="director" class="minimo-select">
                            <option></option>
                            @foreach($all_persons as $person)
                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                        @isset($film) @isset($film->director)
                            <script>
                                $(".minimo-select[name='director']").val('{{ $film->director->id }}')
                            </script>
                        @endif @endif
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-actor-select">
                        <div class="title">Specify roles <i class="fas fa-plus actor-select-add"></i></div>
                        @isset($film)
                            @foreach($film->actors as $actor)
                                <div class="row">
                                    <select name="actors[]" class="minimo-select" id="{{ $actor->id }}-actor">
                                        @foreach($all_persons as $person)
                                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $("#{{ $actor->id }}-actor").val('{{ $actor->id }}');
                                    </script>
                                    <div class="minimo-text-input">
                                        <input type="text" value="{{ $actor->role_name }}" name="roles[]">
                                        <span>Role name</span>
                                    </div>
                                    <i class="fas fa-times actor-select-remove"></i>
                                </div>
                            @endforeach
                        @endif
                        <script>
                            $(".actor-select-add").click(function () {
                                const parent = $(this).parent().parent();
                                parent.append(
                                    $(`<div class="row"><select name="actors[]" class="minimo-select">
                                        @foreach($all_persons as $actor) <option value="{{ $actor->id }}">{{ $actor->name }}</option> @endforeach
                                    </select>
                                    <div class="minimo-text-input">
                                        <input type="text" name="roles[]">
                                        <span>Role name</span>
                                    </div>
                                    <i class="fas fa-times"></i></div>`)
                                );
                                console.log(parent);
                            })
                            $(".actor-select-remove").click(function () {
                                $(this).parent().remove();
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-multiselect" name="genres">
                        <div class="title">Choose genres</div>
                        <div class="select">
                            <?php
                                function test($film, $genre) {
                                    foreach ($film->genres as $fgenre)
                                        if ($fgenre->p_code == $genre->p_code)
                                            return "marked";
                                    return "";
                                }
                            ?>
                            @foreach(\App\Models\Genre::getAllGenres() as $genre)
                                <div class="option @isset($film){{ test($film, $genre) }}@endif" val="{{ $genre->p_code }}" class="marked">{{ $genre->title }}</div>
                            @endforeach
                        </div>
                        <div class="marked-wrapper">

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
                </div>
                <div class="row">
                    <div class="minimo-file-input" style="display: flex; align-items: center;">
                        <input @if(!isset($film)) required @endif type="file" class="creator-meta-image" name="poster" hidden="hidden" accept="image/*">
                        <button type="button" class="minimo-button" default="Choose poster">Choose poster</button>
                        <img class="minimo-poster-preview" style="max-width: 200px; margin-left: 20px;" src="#" alt="">
                        <script>
                            // Minimo file input
                            $(".minimo-file-input").find("button").click(function() {
                                $(this).parent().find("input").click();
                            })
                            $(".minimo-file-input").find("input").change(function() {
                                button = $(this).parent().find("button")
                                if ($(this).val() != '') {
                                    button.html($(this)[0].files[0].name);
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('.minimo-poster-preview').attr('src', e.target.result);
                                    }
                                    reader.readAsDataURL($(this)[0].files[0]);
                                }
                                else {
                                    button.html(button.attr('default'));
                                    $('.minimo-poster-preview').attr('src', "#");
                                }
                            })
                        </script>
                    </div>
                </div>
                <button class="minimo-button" style="margin-top: 30px; width: 100%;">Done</button>
            </div>
        </form>
    </div>
@endsection
