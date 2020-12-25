<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\SearchFilm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{

    public static function search(Request $request) {
        $search = (new SearchFilm())
            ->setTitle($request->input("title"))
            ->setGenres($request->input("genres"))
            ->setPersons($request->input("persons"));

        return view("search", [
            "films" => $search->get(),
            "title" => $request->input("title"),
            "genres" => $request->input("genres") ?? [],
            "persons" => $request->input("persons") ?? [],
        ]);
    }

    public static function index($id) {
        $res = DB::table("films")->where("id", $id)->first();
        if ($res) {
            return view("film-view", [ "film" => new Film($res)] );
        }
        $res = DB::table("person")->where("id", $id)->first();
        if ($res) {
            return view("actor-view", [ "person" => $res, "films" => (new SearchFilm())->setPersons([ $res->id ])->get() ] );
        }
        return view("exception", ["message" => "Page not found!</br><div style='font-size: 72px;'>404</div>"]);
    }

    public static function welcome() {
        return view("home", [
            "message" => "Welcome on MINIMO",
            "films" => (new SearchFilm())->get()
        ]);
    }

    public static function home() {
        return view("home", [
            "message" => "Your films",
            "films" => (new SearchFilm())->setOwn(true)->get()
        ]);
    }
}
