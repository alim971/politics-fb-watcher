<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Politician;
use App\Models\Post;
use Illuminate\Http\Request;

class PoliticianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $politicians = Politician::paginate(10);
        return view('admin.politicians.admin', ['politicians' => $politicians]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.politicians.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $politician = new Politician();
        $politician->name = $request->input('name');
        $politician->surname = $request->input('surname');
        if($request->input('username', false)) {
            $politician->username = $request->input('username');
        }
        $politician->nick = $request->input('nick');
        $politician->image = $request->input('image');
        $politician->save();

        return redirect()->route('politician.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function show(Politician $politician)
    {
        $post = new Post;
        $post->setTable($politician->nick());

        $posts = $post->get();

        $text = nl2br($post->first()->text);
        return view('client.politicians.indexOne', ['politician' => $politician, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function edit(Politician $politician)
    {
        return view('admin.politicians.edit', ['politician' => $politician]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Politician $politician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Politician $politician)
    {
        $politician->delete();
    }
}
