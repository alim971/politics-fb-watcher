<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Service\PostService;
use App\Http\Service\TwitterService;
use App\Models\Tweet;
use App\Models\Twitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TweetController extends Controller
{
    /**
     * @var PostService
     */
    private $twitterService;

    /**
     * Constructor initializing and associating page service
     *
     * NavigationController constructor.
     * @param PostService $postService
     */
    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        return $this->twitterService->allTweets($request);
    }

    public function showAllFrom(Twitter $twitter, Request $request)
    {
        return $this->twitterService->tweetsFrom($twitter, $request);

    }

    public function showOneFrom(Twitter $twitter, $postId, $plus = "true")
    {
        $postId = (int) $postId;

        $table = new Tweet;
        $table->setTable($twitter->db);
        $tweets = $table->get();

        $first = $tweets->first()->id;
        $last = $tweets->last()->id;
        $tmpId = $postId;
        if($plus) {
            while(!$tweets->contains('id', $tmpId)) {
                if($tmpId >= $last) {
                    abort(404);
                }
                $tmpId++;
            }
        } else {
            while(!$tweets->contains('id', $tmpId)) {
                if($tmpId <= $first) {
                    abort(404);
                }
                $tmpId--;
            }
        }
        $next = $tweets->find($tmpId);
        return redirect()
            ->route('showTweet', ['twitter' => $twitter, 'tweet' => $next->id])
            ->with(['first' => $first, 'last' => $last]);
    }

    public function show(Twitter $twitter, $tweetId) {
        $tweetId = (int)$tweetId;
        $table = new Tweet;
        $table->setTable($twitter->db);

        $tweets = $table->get();

        $tweet = $tweets->find($tweetId);
        if(!$tweet) {
            abort(404);
        }
        $first = Session::get('first');
        if($first == null) {
            $first = $tweets->first()->id;
            $last = $tweets->last()->id;
        } else {
            $last = Session::get('last');
        }
        $text = explode("<br />", $tweet->text,2);
        $url = \Illuminate\Support\Facades\Request::url();


        return view('client.tweets.show', [
            'twitter' => $twitter,
            'date' => $tweet->posted,
            'title' => $text[0],
            'text' => $text[1] ?? "",
            'id' => $tweetId,
            'first' => $first,
            'last' => $last,
            'url' => $url,
            'status' => $twitter->url . 'status/' . $tweet->id,
            'toShow' => $tweet->html,
        ]);
    }
}
