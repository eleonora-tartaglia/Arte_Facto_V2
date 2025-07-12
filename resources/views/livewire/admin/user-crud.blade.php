<div class="p-6">
    @if (session()->has('message'))
        <div class="p-3 mb-4 text-center rounded" style="background: rgba(24, 180, 160, 0.3); color: #fff;">
            {{ session('message') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-6 text-center" style="color: #b87333; font-family: 'Cinzel', serif;">
        Gestion des utilisateurs
    </h2>

    <table class="w-full table-auto border border-zinc-700 text-zinc-200 text-sm">
        <thead>
            <tr class="bg-zinc-800 text-[#b87333] uppercase text-xs">
                <th class="p-3">Nom</th>
                <th class="p-3">Email</th>
                <th class="p-3">Inscription</th>
                <th class="p-3">Vérification</th>
                <th class="p-3">Panier</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-zinc-700 align-top">
                    <td class="p-3 font-semibold">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="p-3">
                        @if ($user->identity_verified === 'verified')
                            <span class="px-2 py-1 rounded text-xs" style="background: rgba(24,180,160,0.3); color: #fff; font-family: 'Cinzel', serif;">
                                Vérifié
                            </span>
                        @elseif ($user->identity_verified === 'pending')
                            <span class="px-2 py-1 rounded text-xs" style="background: rgba(118,94,30,0.58); color: #fff; font-family: 'Cinzel', serif;">
                                En attente
                            </span>
                        @else
                            <span class="px-2 py-1 rounded text-xs" style="background: rgba(180,24,24,0.3); color: #fff; font-family: 'Cinzel', serif;">
                                Rejeté
                            </span>
                        @endif
                    </td>
                    <td class="p-3">
                        @if ($user->cartArtifacts->count())
                            <ul class="space-y-2">
                                @foreach ($user->cartArtifacts as $artifact)
                                    <li class="flex items-center gap-2">
                                        <span class="text-xs">{{ $artifact->title }}</span>
                                        <span class="ml-auto text-xs" style="color: #e0cda9; font-style: italic;">
                                            {{ number_format($artifact->price, 2, ',', '.') }} €
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-zinc-500">Aucun article</span>
                        @endif
                    </td>
                    <td class="p-3 space-x-1">
                        @if ($editId === $user->id)
                            <div class="flex flex-col gap-1">
                                <input type="text" wire:model="editName"
                                    class="bg-zinc-800 border border-amber-500 rounded px-2 py-1 text-xs"
                                    placeholder="Nom">
                                <input type="email" wire:model="editEmail"
                                    class="bg-zinc-800 border border-amber-500 rounded px-2 py-1 text-xs"
                                    placeholder="Email">
                                <div class="flex gap-1 mt-1">
                                    <button wire:click="update"
                                        class="px-2 py-1 rounded text-xs"
                                        style="background: rgba(118, 94, 30, 0.58); color: #fff; font-family: 'Cinzel', serif;">
                                        Sauver
                                    </button>
                                    <button wire:click="$set('editId', null)"
                                        class="px-2 py-1 rounded text-xs"
                                        style="background: rgba(144, 24, 180, 0.3); color: #fff; font-family: 'Cinzel', serif;">
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        @else
                            <button wire:click="edit({{ $user->id }})"
                                class="px-2 py-1 rounded text-xs"
                                style="background: rgba(199, 118, 36, 0.5); color: #fff; font-family: 'Cinzel', serif;">
                                Éditer
                            </button>
                            <button wire:click="delete({{ $user->id }})"
                                onclick="return confirm('Supprimer cet utilisateur ?')"
                                class="px-2 py-1 rounded text-xs"
                                style="background: rgba(160, 30, 30, 0.4); color: #fff; font-family: 'Cinzel', serif;">
                                Supprimer
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
