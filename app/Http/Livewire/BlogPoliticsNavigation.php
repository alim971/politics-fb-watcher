<?php

namespace App\Http\Livewire;

use App\Models\Blog;
use App\Models\Politician;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class BlogPoliticsNavigation extends Component
{
    private function areCookiesEnabled() {
        return Cookie::get('laravel_cookie_consent', false);
    }

    public function render()
    {
        $politicians = Politician::all();
        $url = explode('/', url()->current());
        $blog = count($url) < 5 || $url[4] == 'na' ? null : Blog::where('title', $url[4])->first();
//        $all = null;
        foreach ($politicians as $politician) {
            $count = Blog::where('politician_id', $politician->id)->get()->count();
            if($blog) {
                if (!$blog->politician) {
                    Session::put('_blog', $count);
//                    $all = $count - Session::get( '_blog');
                }
                else if ($blog->politician->id == $politician->id) {
                    Session::put($politician->nick() . '_blog', $count);

//                if($this->areCookiesEnabled()) {
//                    Session::put($politician->nick(), $count);
//                    Cookie::queue(Cookie::make($politician->nick(), $count));
//                }
                    if (URL::previous() != URL::current()) {
                        continue;
                    }
                }
//            $diff = $count - Cookie::get($politician->nick());
            } else if(array_key_exists(5, $url) && $url[5] == $politician->username){
                Session::put($politician->nick() . '_blog', $count);

            }
            $diff1 = $count - Session::get($politician->nick() . '_blog');
            $politician->new = $diff1;
//            $politician->new1 = $diff;
        }
//        if($this->areCookiesEnabled()) {
//            Cookie::queue(Cookie::make('update_time', LastUpdate::latest()->first()->created_at->toCookieString()));
//            Session::put('update_time', LastUpdate::latest()->first()->created_at->toCookieString());
//        }
        if(!$blog) {
            Session::put('update_time_blog', Carbon::now()->toCookieString());
        }

        return view('livewire.politics-navigation', [
            'politicians' => $politicians,
            'route' => 'blogOne'
        ]);
    }
}
