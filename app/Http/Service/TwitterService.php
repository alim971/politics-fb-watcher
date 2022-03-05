<?php


namespace App\Http\Service;


use App\Models\LastTweet;
use App\Models\Tweet;
use App\Models\Twitter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class TwitterService
{

    public function tweetsFrom(Twitter $twitter, $request) {
        $table = new Tweet;
        $table->setTable($twitter->db);

        $tweets = new Collection();

        foreach($table->get() as $tweet) {
            $tweets->add($tweet);
        }

        $tweets = $tweets->sortByDesc('posted');
        $page = $request->input('page', 1);
        $perPage = 10;
        $count = $tweets->count();
        $paginate = new LengthAwarePaginator(
            $tweets->forPage($page, $perPage),
            $count,
            $perPage,
            $page,
            ['path' => url(route('indexOneTwitter', ['twitter' => $twitter]))]
        );
        $twitter->newTweets = $count - Session::get($twitter->db, 0);

        return view('client.tweets.indexOne', ['twitter' => $twitter, 'tweets' => $paginate]);
    }

    public function allTweets($request) {
        $lastUpdate = Carbon::parse(
//            Cookie::get('update_time', LastUpdate::latest()->first()->created_at->toCookieString())
            Session::get('live_time', LastTweet::latest()->first()->created_at->toCookieString())
        );
//        View::share('update_time', Carbon::now());
        $table = new Tweet;
        $tweets = new Collection();
        foreach (Twitter::all() as $twitter) {
            $table->setTable($twitter->db);

            foreach($table->get() as $tweet) {
                $tweet->isNew = $tweet->posted->gt($lastUpdate);
                $tweets->add($tweet);
            }
        }
        $tweets = $tweets->sortByDesc('posted');
        $page = $request->input('page', 1);
        $perPage = 10;
        $paginate = new LengthAwarePaginator(
            $tweets->forPage($page, $perPage),
            $tweets->count(),
            $perPage,
            $page,
            ['path' => url(route('indexAllTwitter'))]
        );
        return view('client.tweets.indexAll', ['tweets' => $paginate]);
    }
}
