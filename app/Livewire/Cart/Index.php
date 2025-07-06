<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class Index extends Component
{
    public $cartItems;
    public $total = 0;

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cartItems = Auth::user()->cartItems()->with('artifact')->get();
        $this->total = $this->cartItems->sum(fn ($item) => $item->artifact->price);
    }

    public function remove($id)
    {
        CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        $this->refreshCart();

        // 🚀 émet l'événement global
        $this->dispatch('cartUpdated');
    }


    public function render()
    {
        return view('livewire.cart.index')->layout('components.layouts.app');
    }
}
