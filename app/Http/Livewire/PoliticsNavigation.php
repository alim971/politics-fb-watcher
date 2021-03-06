<?php

namespace App\Http\Livewire;

use App\Models\LastUpdate;
use App\Models\Politician;
use App\Models\Post;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class PoliticsNavigation extends Component
{
    private function areCookiesEnabled() {
       return Cookie::get('laravel_cookie_consent', false);
    }

    public function render()
    {
        $politicians = Politician::all();
        $table = new Post();
        $url = explode('/', url()->current());
        foreach ($politicians as $politician) {
            $table->setTable($politician->nick());
            $count = $table->where('edit', 0)->get()->count();
            if(array_key_exists(4, $url) && $url[4] == $politician->username) {
                Session::put($politician->nick(), $count);

//                if($this->areCookiesEnabled()) {
//                    Session::put($politician->nick(), $count);
//                    Cookie::queue(Cookie::make($politician->nick(), $count));
//                }
                if(URL::previous() != URL::current()) {
                    continue;
                }
            }
//            $diff = $count - Cookie::get($politician->nick());
            $diff1 = $count - Session::get($politician->nick());
            $politician->new = $diff1;
//            $politician->new1 = $diff;
        }
//        if($this->areCookiesEnabled()) {
//            Cookie::queue(Cookie::make('update_time', LastUpdate::latest()->first()->created_at->toCookieString()));
//            Session::put('update_time', LastUpdate::latest()->first()->created_at->toCookieString());
//        }
        if(count($url) == 4) {
            Session::put('update_time', LastUpdate::latest()->first()->created_at->toCookieString());
        }

        return view('livewire.politics-navigation', [
            'politicians' => $politicians,
            'route' => 'indexOne'
        ]);
    }
}
