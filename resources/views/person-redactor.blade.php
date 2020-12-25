@extends('app')

@section('content')

    <style>
        .minimo-multiselect {
            width: 100%;
            padding: 20px 0;
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
            margin-top: 15px;
            margin-bottom: 10px;
        }
    </style>

    <div class="container">
        <form action="@isset($person) {{ route("post-update-person") }} @else {{ route("post-new-person") }} @endif" method="post" class="creator" enctype="multipart/form-data">
            @csrf
            <h1>A new person</h1>
            <div class="meta-field">
                @isset($person)
                    <input type="hidden" name="id" value="{{ $person->id }}">
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
                        <input required type="text" @isset($person) value="{{ $person->name }}" @endif name="name">
                        <span>Name</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <textarea type="textarea" rows="3" name="description">@isset($person){{ $person->description }}@endif</textarea>
                        <span>About</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-file-input" style="display: flex; align-items: center;">
                        <input @if(!isset($person)) required @endif type="file" class="creator-meta-image" name="photo" hidden="hidden" accept="image/*">
                        <button type="button" class="minimo-button" default="Choose photo">Choose photo</button>
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
