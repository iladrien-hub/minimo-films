<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SearchFilm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    public static function index() {
        if (Auth::user() != null && Auth::user()->rights_level >= 1)
            return view("admin", ["films" => (new SearchFilm())->get()]);
        return redirect("home");
    }
}
