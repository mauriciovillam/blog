<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Http\Requests\HomeRequest;

class HomeController extends Controller
{
    public function __invoke(HomeRequest $request, PostRepository $repository)
    {
        return view('home', [
            'posts' => $repository->all($request->input('sort'))
        ]);
    }
}
