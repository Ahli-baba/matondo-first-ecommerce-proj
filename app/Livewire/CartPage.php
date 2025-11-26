<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use App\Livewire\Partials\Navbar;

#[Title('Cart Page - Matondo I Dagupan - CodeMania')]
class CartPage extends Component
{
    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    private function loadCart()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($product_id)
    {
        // update cookie
        $this->cart_items = CartManagement::removeCartItem($product_id);

        // recalc totals
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        // notify navbar – send ONLY a number (NOT ARRAY)
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id, 1);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id, 1);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }
    public function render()
    {
        return view('livewire.cart-page', [
            'cart_items' => $this->cart_items,
            'grand_total' => $this->grand_total
        ]);
    }
}
