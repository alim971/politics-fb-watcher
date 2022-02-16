<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Politician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{

    public function helperOne(Blog $blog, $plus = "true") {
        $blogs = Blog::get()->sortByDesc('date');
        $first = $blogs->last()->id;
        $last = $blogs->first()->id;

        $tmpId = $plus ? $blog->id + 1 : $blog->id - 1;
        if($plus) {
            while(!$blogs->contains('id', $tmpId)) {
                $tmpId++;
            }
        } else {
            while(!$blogs->contains('id', $tmpId)) {
                $tmpId--;
            }
        }
        $next = $blogs->find($tmpId);

        return redirect()
            ->route('showBlog', ['blog' => $next])
            ->with(['first' => $first, 'last' => $last]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {

        $blogs = Blog::all()->sortByDesc('date');
        $first = Session::get('first');
        if($first == null) {
            $first = $blogs->last()->id;
            $last = $blogs->first()->id;
        } else {
            $last = Session::get('last');
        }
        return view('client.blogs.show', [
            'blog' => $blog,
            'first' => $first,
            'last' => $last,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        return view('client.blogs.indexAll', ['blogs' => Blog::paginate(10)]);
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
        return view('client.blogs.indexOne', [
            'blogs' => Blog::where('politician_id', $politician->id)->paginate(10),
            'politician' => $politician,
            ]);
    }


}
