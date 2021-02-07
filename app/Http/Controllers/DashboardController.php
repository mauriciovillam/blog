<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Repositories\PostRepository;

class DashboardController extends Controller
{
    public function __invoke(HomeRequest $request, PostRepository $postRepository)
    {
        return view('dashboard', [
            'posts' => $postRepository->findByUser(auth()->user(), $request->input('sort'))
        ]);
    }
}
