<?php

namespace App\Http\Controllers\Themes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('themes.' . setting('themes.name') . '.pages.home', [
            'theme' => setting('theme.name')
        ]);
    }
}
