<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Concerns\SweetAlert2;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Product Detail Page - Matondo I Dagupan - CodeMania')]
class ProductDetailPage extends Component
{
    use SweetAlert2;

    public $slug;
    public $quantity = 1;
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id): void
    {
        $total_count = CartManagement::addItemToCart(product_id: $product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)
            ->to(Navbar::class);

        $this->dispatch('alert', [
            'text' => 'Product added to the cart successfully!',
            'toast' => true,
            'position' => 'bottom-end',
            'timer' => 3000,
        ]);
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail()
        ]);
    }
}
