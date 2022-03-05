<?php

namespace App\Http\Livewire;

use App\Models\LastTweet;
use App\Models\Tweet;
use App\Models\Twitter;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class LiveNavigation extends Component
{
    private function areCookiesEnabled() {
        return Cookie::get('laravel_cookie_consent', false);
    }

    public function render()
    {
        $twitters = Twitter::all();
        $table = new Tweet;
        $url = explode('/', url()->current());
        foreach ($twitters as $twitter) {
            $table->setTable($twitter->db);
            $count = $table->get()->count();
            if(array_key_exists(4, $url) && $url[4] == $twitter->db) {
                Session::put($twitter->db, $count);

//                if($this->areCookiesEnabled()) {
//                    Session::put($twitter->nick(), $count);
//                    Cookie::queue(Cookie::make($twitter->nick(), $count));
//                }
                if(URL::previous() != URL::current()) {
                    continue;
                }
            }
//            $diff = $count - Cookie::get($twitter->nick());
            $diff1 = $count - Session::get($twitter->db);
            $twitter->new = $diff1;
//            $twitter->new1 = $diff;
        }
//        if($this->areCookiesEnabled()) {
//            Cookie::queue(Cookie::make('update_time', LastUpdate::latest()->first()->created_at->toCookieString()));
//            Session::put('update_time', LastUpdate::latest()->first()->created_at->toCookieString());
//        }
        if(count($url) == 4) {
            Session::put('live_time', LastTweet::latest()->first()->created_at->toCookieString());
        }

        return view('livewire.politics-navigation', [
            'politicians' => $twitters,
            'route' => 'indexOneTwitter'
        ]);
    }
}
