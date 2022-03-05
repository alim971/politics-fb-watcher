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
        $tmpId = $postId;

        $table = new Tweet;
        $table->setTable($twitter->db);
        $tweets = $table->get()->sortByDesc('posted');

        $last = -1;
        $shouldNext = false;

        foreach($tweets as $tweet) {

            if($shouldNext) {
                $tmpId = $tweet->id;
                break;
            }
            $shouldNext = false;
            if($tweet->id == $postId) {
                if($plus) {
                    $tmpId = $last;
                    break;
                } else {
                    $shouldNext = true;
                }
            }
            $last = $tweet->id;
        }
        $first = $tweets->first()->id  == $postId;
        $last = $tweets->last()->id == $postId;

        $next = $tweets->find($tmpId);
        if(!$next) {
            abort(404);
        }
        return redirect()
            ->route('showTweet', ['twitter' => $twitter, 'tweet' => $next->id])
            ->with(['first' => $first, 'last' => $last]);
    }

    public function show(Twitter $twitter, $tweetId) {
        $tweetId = (int)$tweetId;
        $table = new Tweet;
        $table->setTable($twitter->db);

        $tweets = $table->get()->sortByDesc('posted');

        $tweet = $tweets->find($tweetId);
        if(!$tweet) {
            abort(404);
        }
        $first = Session::get('first', 'no');
        if($first == 'no') {
            $first = $tweets->first()->id  == $tweetId;
            $last = $tweets->last()->id == $tweetId;
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
