<div class="p-6">
    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-3 rounded mb-4" style="font-family: 'Cinzel', serif;">
            {{ session('message') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-6 text-center" style="color: #b87333; font-family: 'Cinzel', serif;">
        Vérification des identités
    </h2>

    <table class="w-full border-collapse border border-gray-700">
        <thead>
            <tr class="bg-zinc-800 text-[#b87333] uppercase text-xs">
                <th class="p-3 border border-zinc-700">Nom</th>
                <th class="p-3 border border-zinc-700">Email</th>
                <th class="p-3 border border-zinc-700">Fichier</th>
                <th class="p-3 border border-zinc-700">Statut</th>
                <th class="p-3 border border-zinc-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-zinc-700 text-gray-300">
                    <td class="p-3 border border-zinc-700">{{ $user->name }}</td>
                    <td class="p-3 border border-zinc-700">{{ $user->email }}</td>
                    <td class="p-3 border border-zinc-700">
                        @if ($user->identity_file)
                            <img src="{{ route('admin.users.identity', $user) }}"
                                 alt="Pièce identité"
                                 class="h-20 w-auto rounded shadow-md border border-gray-700">
                        @endif
                    </td>
                    <td class="p-3 border border-zinc-700">
                        @if ($user->identity_verified === 'pending')
                            <span class="px-2 py-1 rounded text-xs"
                                  style="background: rgba(180, 160, 24, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                En attente ⏳
                            </span>
                        @elseif ($user->identity_verified === 'verified')
                            <span class="px-2 py-1 rounded text-xs"
                                  style="background: rgba(24, 180, 160, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Vérifié
                            </span>
                        @elseif ($user->identity_verified === 'rejected')
                            <span class="px-2 py-1 rounded text-xs"
                                  style="background: rgba(180, 24, 24, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Rejeté
                            </span>
                        @endif
                    </td>
                    <td class="p-3 border border-zinc-700 flex gap-2">
                        @if ($user->identity_verified === 'pending')
                            <button wire:click="verify({{ $user->id }})"
                                    class="px-2 py-1 rounded text-xs"
                                    style="background: rgba(24, 180, 160, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Vérifier
                            </button>
                            <button wire:click="reject({{ $user->id }})"
                                    class="px-2 py-1 rounded text-xs"
                                    style="background: rgba(180, 24, 24, 0.3); color: rgb(252, 252, 252); font-family: 'Cinzel', serif;">
                                Rejeter
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
