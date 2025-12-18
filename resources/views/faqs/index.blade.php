<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pusat Bantuan (FAQ)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4 text-gray-700">Pertanyaan yang Sering Diajukan</h3>

                <div class="space-y-4">
                    @forelse($faqs as $faq)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                            <button @click="open = !open" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-t-lg focus:outline-none">
                                <span class="font-semibold text-gray-800 text-left">{{ $faq->question }}</span>
                                <span x-text="open ? '−' : '+'" class="text-xl font-bold text-gray-500"></span>
                            </button>
                            
                            <div x-show="open" class="p-4 bg-white text-gray-600 border-t">
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded mb-2">
                                    {{ $faq->category }}
                                </span>
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">Belum ada data FAQ.</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>