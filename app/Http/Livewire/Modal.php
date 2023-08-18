<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{

    public $buttonClass;
    public $button;
    public $content;
    public $nav;
    public $mierda;
    public $title;
    public function render()
    {
        return view('livewire.modal');
    }
}
