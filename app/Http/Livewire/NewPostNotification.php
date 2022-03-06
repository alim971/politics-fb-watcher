<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewPostNotification extends Component
{
    public $isNew;
    public $route;
    public $del;

    public function render()
    {
        return view('livewire.new-post-notification', ['isNew' => $this->isNew, 'route' => $this->route]);
    }
}
