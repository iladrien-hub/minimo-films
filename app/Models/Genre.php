<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Genre extends Model {

    public static function getFilterRoute($p_code): string {
        return route("search", ["genres[]" => $p_code]);
    }

    public static function saveGenresForFilm($film_id, $genres) {
        DB::table('film_genre')->where("f_film", $film_id)->delete();
        if($genres) foreach ($genres as $genre) {
            DB::table('film_genre')->insert([
                "f_film" => $film_id,
                "f_genre" => $genre
            ]);
        }
    }

    public static function getAllGenres(): Collection {
        return DB::table("genres")->get();
    }
}
