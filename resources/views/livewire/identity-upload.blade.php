<div class="p-6 bg-zinc-900 border border-[#b87333] rounded-lg max-w-sm mx-auto">
    <h2 class="text-xl font-semibold text-[#b87333] mb-6 text-center" style="font-family: 'Cinzel', serif;">
        Téléversez votre pièce d'identité
    </h2>

    @if (session()->has('message'))
        <div class="p-2 mb-4 bg-green-800 text-green-100 rounded text-center">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <input type="file" wire:model="identityFile"
            class="block w-full text-sm text-[#b87333] bg-zinc-800 border border-[#b87333] rounded-lg cursor-pointer focus:outline-none">

        @error('identityFile')
            <div class="text-red-500 text-sm text-center">{{ $message }}</div>
        @enderror

        <div class="flex justify-center space-x-4">
            <button type="submit"
                class="px-4 py-2 bg-[#b87333] hover:bg-[#9f5c2f] rounded text-zinc-100"
                style="font-family: 'Cinzel', serif;">
                Envoyer
            </button>

        </div>
    </form>
</div>
