<x-layouts.app :title="__('Dashboard')">
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-zinc-900 p-6 rounded-xl border border-[#b87333] text-center">
                <div class="text-2xl font-bold text-amber-600">128</div>
                <div class="text-sm text-gray-300 mt-2">Artefacts</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl border border-[#b87333] text-center">
                <div class="text-2xl font-bold text-amber-600">5</div>
                <div class="text-sm text-gray-300 mt-2">Enchères actives</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl border border-[#b87333] text-center">
                <div class="text-2xl font-bold text-amber-600">39 000 €</div>
                <div class="text-sm text-gray-300 mt-2">Total ventes</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl border border-[#b87333] text-center">
                <div class="text-2xl font-bold text-amber-600">3</div>
                <div class="text-sm text-gray-300 mt-2">Vérifications en attente</div>
            </div>
        </div>
        <div class="bg-zinc-900 p-8 rounded-xl border border-[#b87333] mt-8">
            <h2 class="text-lg font-semibold text-amber-600 mb-4">Dernières commandes</h2>
            <p class="text-gray-400">(Section à venir avec liste des dernières transactions.)</p>
        </div>
    </div>
</x-layouts.app>