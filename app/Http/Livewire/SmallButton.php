<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SmallButton extends Component
{
    public $text;
    public $onclick;
    public function render()
    {
        return view('livewire.small-button');
    }
}
