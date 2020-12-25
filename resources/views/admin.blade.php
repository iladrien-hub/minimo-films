@extends('app')

@section('content')
<div class="container">

    <style>
        .minimo-tabs {
            border-bottom: 1px solid #333;
            margin-bottom: 15px;
            display: flex;
        }
        .minimo-tabs .tab {
            padding: 5px 15px;
            border: 1px solid #333;
            margin-bottom: -1px;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            align-self: flex-end;
        }
        .minimo-tabs .tab.active {
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
        }
        .tab-hidden {
            display: none;
        }
    </style>

    <div class="minimo-tabs">
        <div class="tab active" for="films">Films</div>
        <div class="tab" for="genres">Genres</div>
        <div class="tab" for="persons">Persons</div>
    </div>


    <div class="pages-table-wrapper tab-body" id="films">
        @include("admin.tables.films")
    </div>
    <div class="pages-table-wrapper tab-body tab-hidden" id="genres">
        @include("admin.tables.genres")
    </div>
    <div class="pages-table-wrapper tab-body tab-hidden" id="persons">
        @include("admin.tables.persons")
    </div>

    <script>
        $(".minimo-tabs .tab").click(function () {
            $(".minimo-tabs .tab").removeClass("active");
            $(this).addClass("active");
            $(".tab-body").addClass("tab-hidden");
            $("#" + $(this).attr("for")).removeClass("tab-hidden");
        })
    </script>
</div>
@endsection
