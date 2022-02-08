<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Service\PostService;
use App\Models\LastUpdate;
use App\Models\Politician;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * @var PostService
     */
    private $postService;

    /**
     * Constructor initializing and associating page service
     *
     * NavigationController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Politician $politician
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        $lastUpdate = Carbon::parse(
//            Cookie::get('update_time', LastUpdate::latest()->first()->created_at->toCookieString())
            Session::get('update_time', LastUpdate::latest()->first()->created_at->toCookieString())
        );
//        View::share('update_time', Carbon::now());
        $table = new Post;
        $posts = new Collection();
        foreach (Politician::all() as $politician) {
            $table->setTable($politician->nick());

            foreach($table->get() as $post) {
                if($post->edit) {
                    $posts->pop();
                }
                $post->isNew = $post->date->gt($lastUpdate);
                $posts->add($post);
            }
        }
        $posts = $posts->sortByDesc('date');
        $page = $request->input('page', 1);
        $perPage = 10;
        $paginate = new LengthAwarePaginator(
            $posts->forPage($page, $perPage),
            $posts->count(),
            $perPage,
            $page,
            ['path' => url(route('indexAll'))]
        );
        return view('client.posts.indexAll', ['posts' => $paginate]);
    }

    public function showAllFrom(Politician $politician, Request $request)
    {
        $table = new Post;
        $table->setTable($politician->nick());

        $posts = new Collection();

        foreach($table->get() as $post) {
            if($post->edit) {
                $posts->pop();
            }
            $posts->add($post);
        }

        $posts = $posts->sortByDesc('date');
        $page = $request->input('page', 1);
        $perPage = 10;
        $count = $posts->count();
        $paginate = new LengthAwarePaginator(
            $posts->forPage($page, $perPage),
            $count,
            $perPage,
            $page,
            ['path' => url(route('indexOne', ['politician' => $politician]))]
        );
        $politician->newPosts = $count - Session::get($politician->nick(), 0);

        return view('client.posts.indexOne', ['politician' => $politician, 'posts' => $paginate]);
    }

    public function showOneFrom(Politician $politician, $postId, $plus = "true")
    {
        $table = new Post;
        $table->setTable($politician->nick());

        $posts = $table->get()->sortByDesc('date');
        $first = $posts->last()->id;
        $last = $posts->first()->id;
        $nextMin = $last - $first;
        $next = null;
        foreach ($posts as $index => $post) {
            $diff = $post->id - $postId;
            if(($diff > 0 && $plus) || ($diff < 0 && !$plus)) {
                if($nextMin > abs($diff)) {
                    $nextMin = $diff;
                    $next = $post;
                }
            }
            if($post->id == $postId) {
                if($posts->count() == $postId || !$posts[$index + 1]->edit) {
                    $next = $post;
                    break;
                }
                $next = $posts[$index + 1];
                break;
            }

        }
        return redirect()
            ->route('showPost', ['politician' => $politician, 'post' => $next->id])
            ->with(['post' => $next, 'first' => $first, 'last' => $last]);
    }

    public function show(Politician $politician, $postId) {
        $first = Session::get('first');
        if($first == null) {
            $table = new Post;
            $table->setTable($politician->nick());

            $posts = $table->get()->sortByDesc('date');

            $first = $posts->last()->id;
            $last = $posts->first()->id;

            $post = $posts->firstWhere('id', $postId);
        } else {
            $last = Session::get('last');
            $post = Session::get('post');
        }
        $text = explode("\n", $post->text,2);

        return view('client.posts.show', [
            'politician' => $politician,
            'date' => $post->date,
            'img' => $post->img,
            'title' => $text[0],
            'text' => nl2br($text[1] ?? ""),
            'id' => $postId,
            'first' => $first,
            'last' => $last,
        ]);
    }
}
