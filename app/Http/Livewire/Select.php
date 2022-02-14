<?php

namespace App\Http\Livewire;

use App\Models\Politician;
use App\Models\Post;
use Livewire\Component;

class Select extends Component
{
    public $politicianId;
    public $postId;

    public function changeEvent($value)
    {
        $this->politicianId = $value;
    }

    public function render()
    {
        if($this->politicianId) {
            $posts = $table = new Post;
            $table->setTable(Politician::find($this->politicianId)->nick());
        }
        return view('livewire.select', [
            'politicians' => Politician::all(),
            'politicianId' => $this->politicianId,
            'posts' => $posts ? $posts->get() : null,
            'postId' => $this->postId,
        ]);
    }
}
