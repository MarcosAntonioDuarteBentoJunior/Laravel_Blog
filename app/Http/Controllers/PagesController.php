<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $posts = Post::all()->take(9);

        return view('index', compact('posts'));
    }
}
