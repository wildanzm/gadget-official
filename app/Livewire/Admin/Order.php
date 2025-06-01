<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.admin')]
#[Title('Daftar Pesanan')]
class Order extends Component
{
    public function render()
    {
        return view('livewire.admin.order');
    }
}
