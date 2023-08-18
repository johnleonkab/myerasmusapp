<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ButtonSpinnerSm extends Component
{

    public $text;
    public $javascript;
    public $customClass;
    public function render()
    {
        return view('livewire.button-spinner-sm');
    }
}
