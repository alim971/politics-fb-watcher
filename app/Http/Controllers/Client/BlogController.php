<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Politician;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('client.blogs.show', ['blog' => $blog]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        return view('client.blogs.indexAll', ['posts' => Blog::paginate(10)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Politician $politician
     * @param  PRequest $request
     * @return \Illuminate\Http\Response
     */
    public function showAllFrom(Politician $politician, Request $request)
    {
        return view('client.blogs.indexOne', ['politician' => $politician, 'posts' => $paginate]);
    }


}
