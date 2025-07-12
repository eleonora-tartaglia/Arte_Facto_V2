@if(auth()->check() && auth()->user()->isAdmin())
    <x-layouts.app.header_admin :title="$title ?? null">
        {{ $slot }}
    </x-layouts.app.header_admin>
@else
    <x-layouts.app.header :title="$title ?? null">
        {{ $slot }}
    </x-layouts.app.header>
@endif



