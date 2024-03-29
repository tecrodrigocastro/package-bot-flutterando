<?php

namespace App\Livewire;

use Livewire\Component;

class Package extends Component
{


    public $package_list;

    public function render()
    {
        return view('livewire.package');
    }
}
