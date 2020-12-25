<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    public static function remove_genre($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        DB::table('genres')->where('p_code', '=', $id)->delete();
        return redirect("admin");
    }

    public static function add_genre(Request $request) {
        try {
            if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
            DB::table('genres')->insert([
                "p_code" => $request->input("id"),
                "title" => $request->input("title")
            ]);
            return redirect("admin");
        } catch (QueryException $e) {
            $message = "SQL Exception</br>".$e->getMessage();
            return view("exception", ["message" => $message]);
        }
    }

    public static function update_genre(Request $request) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        DB::table('genres')->where("p_code", $request->input("id") )->update([
            "title" => $request->input("title")
        ]);
        return redirect("admin");
    }

    public static function create_index() {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        return view("genre-redactor");
    }

    public static function update_index($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $res = DB::table("genres")->where("p_code", $id)->first();
        if ($res)
            return view("genre-redactor", [ "genre" =>  $res ]);
        return view("exception", ["message" => "Page not found!</br><div style='font-size: 72px;'>404</div>"]);
    }

}
