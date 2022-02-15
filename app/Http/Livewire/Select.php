<?php

namespace App\Http\Livewire;

use App\Models\Politician;
use App\Models\Post;
use Livewire\Component;

class Select extends Component
{
    public $politicians;
//    public $posts;
    public $text;

    public $selectedPolitician;
    public $selectedPost = null;

    public function mount()
    {
        $this->politicians = Politician::all();
//        $this->posts = collect();
        $this->selectedPolitician = null;
        $this->selectedPost = null;
    }

    public function render()
    {
        return view('livewire.select');
    }

    public function updatedSelectedPolitician($politician)
    {
        $this->selectedPost = NULL;
        $this->text = NULL;
    }

    public function updatedSelectedPost($post)
    {
        $table = new Post;
        $table->setTable(Politician::find($this->selectedPolitician)->nick());
        $this->text = nl2br($table->find($post)->text);
    }
}