<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
#[Title('Penjualan')]

class Sale extends Component
{
    public function render()
    {
        return view('livewire.admin.sale');
    }
}
