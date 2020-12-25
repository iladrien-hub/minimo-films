<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Film extends Model {

    public $id, $title, $description, $poster, $genres, $price, $actors, $director, $video, $bought;

    public function __construct($source) {
        $this->id = $source->id;
        $this->title = $source->title;
        $this->description = $source->description;
        $this->poster = $source->poster;
        $this->price = $source->price;
        $this->video = $source->video;
        // Views
        $this->bought = sizeof(DB::table("user_film") ->where("f_film", $this->id )->get());
        // Director
        $this->director = DB::table("person")->where("id", $source->director)->first();
        // Genres
        $this->genres = DB::table("genres")
            ->whereIn("p_code", DB::table("film_genre")->where("f_film", "=", $this->id)->pluck("f_genre")->toArray())
            ->get();
        // Roles
        $this->actors = DB::table("role")
            ->leftJoin('person', 'role.f_person', '=', 'person.id')
            ->where("f_film", $this->id)
            ->get();
    }

    public static function isPurchased($id) {
        if (Auth::user())
            return DB::table("user_film")
                ->where("f_user", Auth::user()->id)
                ->where("f_film", $id)
                ->first();
        return null;
    }
}
