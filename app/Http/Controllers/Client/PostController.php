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
     * @param Request $request
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
        $postId = (int) $postId;

        $table = new Post;
        $table->setTable($politician->nick());
        $posts = $table->get()->sortByDesc('date');
        $current = $posts->find($plus ? $postId - 1 : $postId + 1);

        $first = $posts->last()->id;
        $last = $posts->first()->id;
        $tmpId = $postId;
        if($plus) {
            while(!$posts->contains('id', $tmpId) || ($posts->contains('id', $tmpId + 1) && $posts->find($tmpId + 1)->edit)) {
                if($tmpId >= $last) {
                    break;
                }
                $tmpId++;
//                $posts->where('id', $tmpId + 1)->
            }
        } else {
            while(!$posts->contains('id', $tmpId) || ($posts->contains('id', $tmpId + 1) && $posts->find($tmpId + 1)->edit)) {
                if($tmpId <= $first) {
                    break;
                }
                $tmpId--;
//                $posts->where('id', $tmpId + 1)->
            }
        }
        $next = $posts->find($tmpId);
//        $nextMin = $last - $first;
//        $next = null;
//        foreach ($posts as $post) {
//            $diff = $post->id - $postId;
//            if(($diff > 0 && $plus) || ($diff < 0 && !$plus)) {
//                if($nextMin > abs($diff)) {
//                    $nextMin = $diff;
//                    $next = $post;
//                }
//            }
//            if($post->id == $postId) {
//                if(!$posts->contains('id', $postId + 1) || !$posts[$postId + 1]->edit) {
//                    $next = $post;
//                    break;
//                }
//                $index = $postId;
//                while($posts->contains('id', $postId + 1) && $posts[$index + 1]->edit) {
//                    $index++;
//                }
//                $next = $posts[$index];
//                break;
//            }
//
//        }
        return redirect()
            ->route('showPost', ['politician' => $politician, 'post' => $next->id])
            ->with(['first' => $first, 'last' => $last]);
    }

    public function show(Politician $politician, $postId) {
        $table = new Post;
        $table->setTable($politician->nick());

        $posts = $table->get()->sortByDesc('date');

        $post = $posts->find($postId);
        $first = Session::get('first');
        if($first == null) {
            $first = $posts->last()->id;
            $last = $posts->first()->id;
        } else {
            $last = Session::get('last');
        }
        $text = explode("\n", $post->text,2);
        $url = \Illuminate\Support\Facades\Request::url();
        if($post->edit) {
            $tmpId = $post->id - 1;
            while(!$posts->contains('id', $tmpId) || ($posts->find($tmpId)->edit)) {
                $tmpId--;
            }
            $url = str_replace("$post->id", "$tmpId", $url);
        }

        return view('client.posts.show', [
            'politician' => $politician,
            'date' => $post->date,
            'img' => $post->img,
            'photo' => $post->photo,
            'title' => $text[0],
            'text' => nl2br($text[1] ?? ""),
            'id' => $postId,
            'first' => $first,
            'last' => $last,
            'url' => $url
        ]);
    }
}
