<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

#[Title('Success - DCodeMania')]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    public $order = null;
    public $message = null;

    public function mount()
    {
        // find latest order for this user
        $this->order = Order::with('address')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$this->order) {
            $this->message = "Order not found.";
            return;
        }

        // IF STRIPE PAYMENT
        if ($this->session_id) {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $session = Session::retrieve($this->session_id);

                if ($session->payment_status === 'paid') {
                    $this->order->payment_status = 'paid';
                } else {
                    $this->order->payment_status = 'failed';
                    $this->order->save();
                    redirect()->route('cancel')->send();
                }

                $this->order->save();
            } catch (\Exception $e) {
                $this->message = "Stripe error: " . $e->getMessage();
            }
        }
        // ELSE COD → nothing to verify
    }

    public function render()
    {
        return view('livewire.success-page', [
            'order' => $this->order,
            'message' => $this->message
        ]);
    }
}
