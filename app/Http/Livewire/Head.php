<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class Head extends Component
{

    public $url;
    public $type;
    public $title;
    public $description;
    public $descriptionGoogle;
    public $keywords;
    public $img;
    public $politician;
    public $text;
    public $app = null;
    public $cke = null;

    public function render()
    {
        $this->url = url()->full();
        $this->type = "website";
        if($this->text != null) {
            $this->description = Str::contains($this->title, $this->text) ? $this->text : Str::words($this->text, 25);
            $this->descriptionGoogle = "Facebook príspevok od politika " . $this->politician->fullName() . ": " . Str::contains($this->title, $this->text) ? $this->text : Str::words($this->text, 25);
            $this->type = "article";
            $this->keywords = $this->politician->fullName() . ',' . $this->politician->name . ',' . $this->politician->surname . ',' . $this->politician->nick . ', príspevok, Facebook, novinka, aktualita, Res Publica, Vec verejná, politika, Slovensko, SR';
            if(Str::contains('reakcia' ,$this->url)) {
                $this->descriptionGoogle = 'Reakcia na ' . $this->descriptionGoogle;
                $this->keywords .= 'blog, reakcia,';
            }

        } else if($this->politician != null){
            $this->title = 'Príspevky od: ' .$this->politician->fullName();
            $this->descriptionGoogle = $this->description = 'Facebook príspevky od:' .$this->politician->fullName();
            $this->img = $this->politician->image;
            $this->keywords = $this->politician->fullName() . ',' . $this->politician->name . ',' . $this->politician->surname . ',' . $this->politician->nick . ', Res Publica, Vec verejná, politika, Slovensko, SR, aktualne, novinky, príspevky, Facebook,';
            if(Str::contains('reakcia', $this->url)) {
                $this->descriptionGoogle = 'Nové reakcie na ' . $this->descriptionGoogle;
                $this->description = 'Nové reakcie na ' . $this->description;
                $this->keywords .= 'blog, reakcia,';
            }
        } else {
            $this->title = 'Vec verejná - Res Publica';
            $this->descriptionGoogle = $this->description = 'Stránka s automatickým sledovaním facebook príspevkov mnohých politikov a reakciami na nich';
            $this->keywords = 'Res Publica, Vec verejná, politika, Slovensko, SR, aktualne, novinky, príspevky, Blaha, Ľuboš, Ľuboš Blaha, Kotleba, Fico, Róbert Fico, Chmelár, Eduard Chmelár, Facebook,';
        }
        return view('livewire.head');
    }
}
