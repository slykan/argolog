<div
    x-data="{ show: !localStorage.getItem('cookie_consent') }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 border-t border-gray-700 shadow-2xl"
    style="display: none;"
>
    <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-300 text-center sm:text-left">
            Koristimo kolačiće kako bismo poboljšali vaše iskustvo na stranici.
            <a href="{{ route('privacy') }}" class="underline text-green-400 hover:text-green-300 transition whitespace-nowrap">Politika privatnosti</a>
        </p>
        <div class="flex gap-3 flex-shrink-0">
            <button
                @click="localStorage.setItem('cookie_consent', 'accepted'); show = false"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition"
            >
                Prihvaćam
            </button>
            <button
                @click="localStorage.setItem('cookie_consent', 'rejected'); show = false"
                class="bg-gray-700 hover:bg-gray-600 text-gray-200 text-sm font-medium px-4 py-2 rounded-xl transition"
            >
                Odbijam
            </button>
        </div>
    </div>
</div>
