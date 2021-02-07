<?php

namespace App\Http\Controllers;

use App\Actions\CreatePostAction;
use App\Http\Requests\StorePostRequest;

class StorePostController extends Controller
{
    public function __invoke(StorePostRequest $request, CreatePostAction $createPostAction)
    {
        $createPostAction->execute($request->validated(), auth()->user());
        return redirect(route('dashboard'))->with('success', __('The post has been created successfully.'));
    }
}
