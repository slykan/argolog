<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dobrodošli, {{ auth()->user()->naziv_gospodarstva ?: auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Pozdrav --}}
            <div class="bg-white shadow-sm rounded-xl p-8">
                <h3 class="text-lg font-semibold text-green-700 mb-2">AgroLog &mdash; evidencija poljoprivrednih radova</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Ovdje vodite evidenciju gnojidbe i prskanja vaših parcela sukladno zakonskim obavezama.
                    Unesite ARCOD parcele i kulture, a zatim dodajte zapise o gnojidbi i primjeni sredstava za zaštitu bilja.
                    Svaku evidenciju možete filtrirati, urediti i ispisati kao službeni obrazac.
                </p>
            </div>

            {{-- Brze veze --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <a href="{{ route('parcele') }}" class="bg-white shadow-sm rounded-xl p-8 hover:shadow-md transition group border border-transparent hover:border-green-200">
                    <div class="text-4xl mb-4">&#127807;</div>
                    <h4 class="font-semibold text-gray-800 group-hover:text-green-700 transition mb-1">Parcele &amp; Kulture</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Upravljajte ARCOD parcelama i kulturama koje na njima uzgajate.</p>
                </a>
                <a href="{{ route('gnojidba') }}" class="bg-white shadow-sm rounded-xl p-8 hover:shadow-md transition group border border-transparent hover:border-green-200">
                    <div class="text-4xl mb-4">&#129517;</div>
                    <h4 class="font-semibold text-gray-800 group-hover:text-green-700 transition mb-1">Evidencija gnojidbe</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Unosite i pregledavate zapise o primjeni gnojiva po parcelama.</p>
                </a>
                <a href="{{ route('prskanje') }}" class="bg-white shadow-sm rounded-xl p-8 hover:shadow-md transition group border border-transparent hover:border-green-200">
                    <div class="text-4xl mb-4">&#128167;</div>
                    <h4 class="font-semibold text-gray-800 group-hover:text-green-700 transition mb-1">Evidencija prskanja</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Vodite evidenciju o upotrebi sredstava za zaštitu bilja.</p>
                </a>
            </div>

            {{-- Parcele i kulture --}}
            @php
                $parcele = auth()->user()->parcele()->with(['kulture' => fn($q) => $q->orderByDesc('godina')->orderBy('naziv')])->orderBy('arkod_broj')->get();
            @endphp

            @if($parcele->isNotEmpty())
            <div class="bg-white shadow-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-gray-700">Moje parcele</h3>
                    <a href="{{ route('parcele') }}" class="text-xs text-green-700 hover:underline">Upravljaj &rarr;</a>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b">
                            <th class="text-left pb-1 font-medium">ARKOD</th>
                            <th class="text-right pb-1 font-medium">Površina</th>
                            <th class="text-left pb-1 pl-6 font-medium">Kulture</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parcele as $parcela)
                        <tr class="border-b border-gray-50">
                            <td class="py-1.5 font-medium text-gray-800">{{ $parcela->arkod_broj }}</td>
                            <td class="py-1.5 text-right text-gray-500">{{ number_format($parcela->povrsina_ha, 2) }} ha</td>
                            <td class="py-1.5 pl-6 text-gray-600">
                                {{ $parcela->kulture->map(fn($k) => $k->naziv.' ('.$k->godina.')')->join(', ') ?: '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Kontakt --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-sm text-gray-600">
                <p>
                    Za prijedloge, dodatke ili prijavu problema obratite se na:
                    <a href="mailto:slynetwork@gmail.com" class="font-semibold text-green-700 hover:underline">slynetwork@gmail.com</a>
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
