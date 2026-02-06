@props(['title', 'description', 'icon'])

<div class="glass hover-glow rounded-xl p-6">
    <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center mb-4">
        {{ $icon }}
    </div>
    <h3 class="text-lg font-semibold text-white mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-400 leading-relaxed">{{ $description }}</p>
</div>
