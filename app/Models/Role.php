<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    public static function saveRoles($film_id, $actors, $roles) {
        DB::table('role')->where("f_film", $film_id)->delete();
        for($i = 0; $i < sizeof($actors); $i++ ) {
            DB::table('role')->insert([
                "f_film" => $film_id,
                "f_person" => $actors[$i],
                "role_name" => $roles[$i],
            ]);
        }
    }
}
