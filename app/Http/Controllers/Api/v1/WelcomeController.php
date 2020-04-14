<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // return response()->json([
        //     'name'    => config('project.name').' API',
        //     'message' => 'This is a base endpoint of v1 API.',
        //     'links'   => [
        //         [
        //             'rel'  => 'self',
        //             'href' => route(\Route::currentRouteName())
        //         ],
        //         [
        //             'rel'  => 'api.v1.articles.index',
        //             'href' => route('api.v1.articles.index')
        //         ],
        //         [
        //             'rel'  => 'api.v1.tags.index',
        //             'href' => route('api.v1.tags.index')
        //         ],
        //     ],
        // ], 200, [], JSON_PRETTY_PRINT);
        return view('welcome')->with([
            'name'    => config('project.name').' API',
            'message' => 'This is a base endpoint of v1 API.',
        ]);
    }
}
