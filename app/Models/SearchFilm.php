<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchFilm extends Model
{
    public $title = null;
    public $genres = null;
    public $order_by = null;
    public $persons = null;
    public $own = null;

    public function setOwn($own): SearchFilm {
        $this->own = $own;
        return $this;
    }

    public function setPersons($persons): SearchFilm {
        $this->persons = $persons;
        return $this;
    }

    public function setTitle($title): SearchFilm {
        $this->title = $title;
        return $this;
    }

    public function setGenres($genres): SearchFilm {
        $this->genres = $genres;
        return $this;
    }

    public function setOrderBy(string $order_by): SearchFilm {
        $this->order_by = $order_by;
        return $this;
    }

    public function get() {
        $req = DB::table('films');
        if ($this->title != null)
            $req = $req->where("title", "like", "%".$this->title."%");
        if ($this->genres != null) {
            $req = $req->where(function($query){
                foreach ($this->genres as $genre)
                    $query->whereIn("id", DB::table("film_genre")->where("f_genre", $genre)->pluck("f_film")->toArray() );
            });
        }
        if ($this->persons != null) {
            foreach ($this->persons as $person)
                $req = $req->where(function($query) use ($person) {
                    $query->where("director",  $person)
                        ->orWhereIn("id", DB::table("role")->where("f_person", $person)->pluck("f_film")->toArray());
                });
        }
        if ($this->own && Auth::user()) {
            $req = $req->whereIn("id", DB::table("user_film")->where("f_user", Auth::user()->id)->pluck("f_film")->toArray() );
        }
        if ($this->order_by != null) {
            $req = $req->orderBy($this->order_by);
        }
        // Get
        $resp = $req->get();
        $result = new ArrayObject();
        foreach ($resp as $item)
            $result->append(new Film($item));
        return $result;
    }

}
