<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteButton extends Component
{
    public $result_slug;
    public function render()
    {
        return view('livewire.delete-button');
    }
}
