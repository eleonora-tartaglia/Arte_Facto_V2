<div>
    <flux:navbar.item class="relative" icon="shopping-cart" :href="route('cart.index')" wire:navigate>
        @if($count > 0)
            <flux:badge size="xs" variant="primary" class="absolute -top-1 -right-1">
                {{ $count }}
            </flux:badge>
        @endif
    </flux:navbar.item>
</div>
