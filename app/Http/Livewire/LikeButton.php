<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikeButton extends Component
{

    public $slug;
    public $type;
    public $target_id;
    public function render()
    {
        return view('livewire.like-button');
    }
}
