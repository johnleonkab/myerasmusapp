<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RequestFriendship extends Component
{

    public $unid;
    public $requested;
    public $friends;
    public function render()
    {
        return view('livewire.request-friendship');
    }
}
