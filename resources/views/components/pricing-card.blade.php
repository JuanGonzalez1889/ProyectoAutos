@props(['plan', 'price', 'period', 'features', 'popular' => false, 'cta', 'ctaLink'])

<div class="relative {{ $popular ? 'border-2 border-blue-500' : 'glass' }} rounded-xl p-8 hover-glow flex flex-col min-h-[440px]">
    @if($popular)
        <div class="absolute -top-4 left-1/2 -translate-x-1/2" style="width: 59%">
            <span class="px-4 py-1 bg-blue-500 text-white text-xs font-bold rounded-full uppercase">El más elegido</span>
        </div>
    @endif
    
    <h3 class="text-lg font-semibold text-white mb-2">{{ $plan }}</h3>
    <div class="mb-6">
        <span class="text-4xl font-bold text-white">${{ $price }}</span>
        <span class="text-gray-400 text-sm">/{{ $period }}</span>
    </div>
    
    <ul class="space-y-3 mb-8 flex-1">
        @foreach($features as $feature)
        <li class="flex items-start gap-2">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm text-gray-300">{{ $feature }}</span>
        </li>
        @endforeach
    </ul>
    
    <a href="{{ $ctaLink }}" class="block w-full py-3 mt-auto {{ $popular ? 'btn-gradient' : 'bg-white/5 hover:bg-white/10' }} rounded-lg text-center font-semibold text-white transition-all">
        {{ $cta }}
    </a>
</div>
