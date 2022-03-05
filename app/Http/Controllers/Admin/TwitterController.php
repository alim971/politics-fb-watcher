<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Twitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TwitterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $twitters = Twitter::paginate(10);
        return view('admin.twitters.admin', ['twitters' => $twitters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.twitters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $twitter = new Twitter();
        $twitter->name = $request->input('name');
        $twitter->db = $request->input('db');
        $twitter->url = $request->input('url');
        $twitter->nick = $request->input('nick');
        $twitter->save();
        Artisan::call('tweets:watch');
        return redirect()->route('twitter.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function edit(twitter $twitter)
    {
        return view('admin.twitters.edit', ['twitter' => $twitter]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, twitter $twitter)
    {
        $twitter->name = $request->input('name');
        $twitter->db = $request->input('db');
        $twitter->url = $request->input('url');
        $twitter->nick = $request->input('nick');
        $twitter->save();

        return redirect()->route('twitter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function destroy(twitter $twitter)
    {
        $twitter->delete();
    }
}
