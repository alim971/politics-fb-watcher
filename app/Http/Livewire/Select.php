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
        if($this->selectedPost) {
            $this->updatedSelectedPost($this->selectedPost);
        }
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
        if(!$post) {
            $this->text = NULL;
            return;
        }
        if(!$this->selectedPolitician) {
            $this->updatedSelectedPolitician(null);
            return;
        }
        $table = new Post;
        $table->setTable(Politician::find($this->selectedPolitician)->nick());
        $this->text = nl2br($table->find($post)->text);
    }
}
