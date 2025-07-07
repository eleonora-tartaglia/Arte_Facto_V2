<x-layouts.app>
    <div class="min-h-screen bg-black text-[#D8D3C3] py-12 px-6">
        <div class="max-w-5xl mx-auto border border-[#433611] rounded-xl p-8 bg-[#1A1A1A] shadow-lg">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <img src="/images/demo-anubis.png" alt="Statuette d'Anubis" class="w-full rounded-xl border border-[#7B5E1F]">
                    <div class="mt-4 flex justify-between text-sm text-gray-400">
                        <span>Lot #42</span>
                        <span>Egypte Ancienne</span>
                    </div>
                </div>

                <div>
                    <h1 class="text-3xl font-bold mb-4 text-amber-600">Statuette d'Anubis</h1>

                    <div class="text-xl mb-4">
                        <span class="text-gray-300">Prix actuel :</span>
                        <span class="text-amber-500 font-semibold">8 500 €</span>
                    </div>

                    <div class="bg-[#0c0c0c] p-4 rounded-lg border border-[#433611] mb-6">
                        <p class="text-sm text-gray-400 mb-1">Fin de l'enchère dans :</p>
                        <div class="text-3xl font-mono text-green-500">02:14:35</div>
                    </div>

                    <form class="flex gap-4">
                        <input type="number" placeholder="Votre enchère (€)" class="w-full p-2 rounded bg-[#1A1A1A] border border-[#433611] focus:ring-2 focus:ring-[#A9842C] transition">
                        <button type="submit" class="bg-[#7B5E1F] px-4 py-2 rounded-xl hover:bg-[#A9842C] transition">Enchérir</button>
                    </form>

                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-amber-600 mb-2">Historique des enchères</h2>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between border-b border-[#433611] pb-1">
                                <span>Lara Croft</span>
                                <span>8 500 €</span>
                            </li>
                            <li class="flex justify-between border-b border-[#433611] pb-1">
                                <span>Benjamin Gates</span>
                                <span>8 200 €</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Jack Sparrow</span>
                                <span>7 800 €</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-amber-600 mb-2">Description</h3>
                <p class="text-gray-300 leading-relaxed italic">
                    Statuette en bronze du dieu Anubis, maître des nécropoles égyptiennes, gardien de la pesée des âmes. 
                    Chef-d'œuvre du Nouvel Empire conservant toute sa majesté funéraire.
                </p>
            </div>
        </div>
    </div>

</x-layouts.app>