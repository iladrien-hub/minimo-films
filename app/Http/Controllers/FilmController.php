<?php

namespace App\Http\Controllers;

use App\Console\Commands\ClearImages;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller {

    public static function purchase($id) {
        if(Auth::user()) {
            DB::table('user_film')->insert([
                "f_user" => Auth::user()->id,
                "f_film" => $id
            ]);
            return redirect()->route("page", [ "id" => $id ]);
        }
        return redirect("login");
    }

    public static function remove_film($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $page = DB::table('films')->where('id', '=', $id)->first();
        if ($page) {
            DB::table('films')->where('id', '=', $id)->delete();
            Image::deleteImage($page->poster);
        }
        return redirect("admin");
    }

    public static function update_film(Request $request) {
        try {
            if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
            $resp = DB::table('films')->where("id", $request->input("id"))->first();
            if ($resp) {
                if ($request->hasFile("poster")) {
                    $new_poster = Image::saveImage($request->file('poster'));
                    Image::deleteImage($resp->poster);
                } else {
                    $new_poster = $resp->poster;
                }
                DB::table('films')->where("id", $request->input("id"))->update([
                    "description" => $request->input("description"),
                    "price" => $request->input("price"),
                    "poster" => $new_poster,
                    "title" => $request->input("title"),
                    "video" => $request->input("video"),
                    "director" => $request->input("director")
                ]);
                Role::saveRoles($request->input("id"), $request->input("actors"), $request->input("roles"));
                Genre::saveGenresForFilm($request->input("id"), $request->input("genres"));
                return redirect("admin");
            }
            return view("exception", ["message" => "Page not found!"]);
        } catch (QueryException $e) {
            Artisan::call('clearImages');
            $message = "SQL Exception</br>".$e->getMessage();
            return view("exception", ["message" => $message]);
        }
    }

    public static function add_film(Request $request) {
        try {
            if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
            DB::table('films')->insert([
                "id" => $request->input("id"),
                "description" => $request->input("description"),
                "price" => $request->input("price"),
                "poster" => Image::saveImage($request->file('poster')),
                "title" => $request->input("title"),
                "video" => $request->input("video"),
                "director" => $request->input("director")
            ]);
            Role::saveRoles($request->input("id"), $request->input("actors"), $request->input("roles"));
            Genre::saveGenresForFilm($request->input("id"), $request->input("genres"));
            return redirect("admin");
        } catch (QueryException $e) {
            Artisan::call('clearImages');
            $message = "SQL Exception</br>".$e->getMessage();
            return view("exception", ["message" => $message]);
        }
    }

    public static function create_index() {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        return view("film-redactor");
    }

    public static function update_index($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $resp = DB::table('films')->where('id', '=', $id)->first();
        if ($resp)
            return view("film-redactor", [ "film" => new Film($resp) ]);
        return view("exception", ["message" => "Page not found!</br><div style='font-size: 72px;'>404</div>"]);
    }

}
