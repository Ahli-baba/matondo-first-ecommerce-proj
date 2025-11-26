<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public $total_count = 0;

    public function mount()
    {
        $this->total_count = CartManagement::getTotalQuantity();
    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count)
    {
        // $total_count is already an integer
        $this->total_count = (int) $total_count;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
