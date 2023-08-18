<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ButtonSpinner extends Component
{

    public $text;
    public $javascript;
    public function render()
    {
        return view('livewire.button-spinner');
    }
}
