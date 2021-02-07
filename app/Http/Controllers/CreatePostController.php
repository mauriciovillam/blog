<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreatePostController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('create-post');
    }
}
