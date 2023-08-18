<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $customClass;
    public $text;
    public $javascript;
    public function render()
    {
        return view('livewire.button');
    }
}
