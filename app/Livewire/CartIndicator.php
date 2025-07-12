<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartIndicator extends Component
{
    public int $count = 0;

    protected $listeners = ['cartUpdated' => 'refreshCount'];

    public function mount()
    {
        $this->refreshCount();
    }

    public function refreshCount()
    {
        if (Auth::check()) {
            $this->count = Auth::user()->cartItems()->count();
        }
    }

    public function render()
    {
        $this->refreshCount();
        return view('livewire.cart-indicator');
    }
}



