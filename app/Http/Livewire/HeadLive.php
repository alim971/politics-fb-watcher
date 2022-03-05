<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class HeadLive extends Component
{

    public $url;
    public $type;
    public $title;
    public $description;
    public $descriptionGoogle;
    public $keywords;
    public $img = null;
    public $twitter;
    public $text;
    public $app = null;
    public $cke = null;

    public function render()
    {
        $this->url = url()->full();
        $this->type = "website";
        if($this->text != null) {
            $this->description = Str::contains($this->title, $this->text) ? $this->text : Str::words($this->text, 25);
            $this->descriptionGoogle = "Tweet od " . $this->twitter->name . ": " . $this->description;
            $this->type = "article";
            $this->keywords = $this->twitter->name . ', tweet, twitter, novinka, aktualita, ukrajina, UA, UK, Res Publica, Vec verejná, politika, Slovensko, SR';

        } else if($this->twitter != null){
            $this->title = 'Tweety od: ' . $this->twitter->name;
            $this->descriptionGoogle = $this->description = 'Tweety od:' . $this->twitter->name;
            $this->keywords = $this->twitter->name . ', tweet, twitter, novinka, aktualita, ukrajina, UA, UK, Res Publica, Vec verejná, politika, Slovensko, SR';

        } else {
            $this->title = 'Vec verejná - Res Publica';
            $this->descriptionGoogle = $this->description = 'Stránka s automatickým sledovaním facebook príspevkov mnohých politikov a reakciami na nich, live aktuality z twitteru s novinkami z Ukrajiny';
            $this->keywords = 'Res Publica, Vec verejná, politika, Slovensko, SR, Ukrajina, twitter, aktualne, novinky, príspevky, Blaha, Ľuboš, Ľuboš Blaha, Kotleba, Fico, Róbert Fico, Chmelár, Eduard Chmelár, Facebook,';
        }
        return view('livewire.head');
    }
}
