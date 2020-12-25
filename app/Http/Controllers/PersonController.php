<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public static function remove_person($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $page = DB::table('person')->where('id', '=', $id)->first();
        if ($page) {
            DB::table('person')->where('id', '=', $id)->delete();
            Image::deleteImage($page->photo);
        }
        return redirect("admin");
    }


    public static function add_person(Request $request) {
        try {
            if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
            DB::table('person')->insert([
                "id" => $request->input("id"),
                "description" => $request->input("description"),
                "photo" => Image::saveImage($request->file('photo')),
                "name" => $request->input("name")
            ]);
            return redirect("admin");
        } catch (QueryException $e) {
            Artisan::call('clearImages');
            $message = "SQL Exception</br>".$e->getMessage();
            return view("exception", ["message" => $message]);
        }
    }

    public static function update_person(Request $request) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $resp = DB::table('person')->where("id", $request->input("id"))->first();
        if ($resp) {
            if ($request->hasFile("photo")) {
                $new_photo = Image::saveImage($request->file('photo'));
                Image::deleteImage($resp->photo);
            } else {
                $new_photo = $resp->photo;
            }
            DB::table('person')->where("id", $request->input("id"))->update([
                "description" => $request->input("description"),
                "name" => $request->input("name"),
                "photo" => $new_photo,
            ]);
            return redirect("admin");
        }
        return view("exception", ["message" => "Page not found!</br><div style='font-size: 72px;'>404</div>"]);
    }

    public static function create_index() {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        return view("person-redactor");
    }

    public static function update_index($id) {
        if (Auth::user() == null || Auth::user()->rights_level < 1) return "You have no rights for this action";
        $res = DB::table("person")->where("id", $id)->first();
        if ($res)
            return view("person-redactor", [ "person" =>  $res ]);
        return view("exception", ["message" => "Page not found!</br><div style='font-size: 72px;'>404</div>"]);
    }
}
