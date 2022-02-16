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
            $this->type = "article";

        } else if($this->politician != null){
            $this->title = 'Príspevky od: ' .$this->politician->fullName();
            $this->description = 'Nové facebook príspevky od:' .$this->politician->fullName();
            $this->img = $this->politician->image;
        } else {
            $this->title = 'Vec verejná - Res Publica';
            $this->description = 'Sledovač príspevkov na facebooku od rôznych politikov';
        }
        return view('livewire.head');
    }
}
