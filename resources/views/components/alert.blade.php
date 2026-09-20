@props([
    'variant' => 'info',
    'title' => null,
    'description' => null,
    'dismissible' => false,
])

@php
    $variant = strtolower($variant);

    $styles = [
        'info' => [
            'container' => 'bg-[#0b0d14] border border-[#a855f7]/35 text-white shadow-[0_10px_30px_rgba(0,0,0,0.5),0_0_15px_rgba(168,85,247,0.15)]',
            'icon_color' => 'text-[#a855f7]',
            'title_color' => 'text-white',
            'desc_color' => 'text-[#9ca3af]',
            'icon' => 'circle-alert',
        ],
        'success' => [
            'container' => 'bg-[#09140e] border border-[#22c55e]/35 text-white shadow-[0_10px_30px_rgba(0,0,0,0.5),0_0_15px_rgba(34,197,94,0.15)]',
            'icon_color' => 'text-[#22c55e]',
            'title_color' => 'text-white',
            'desc_color' => 'text-[#9ca3af]',
            'icon' => 'circle-check',
        ],
        'warning' => [
            'container' => 'bg-[#141009] border border-[#f59e0b]/35 text-white shadow-[0_10px_30px_rgba(0,0,0,0.5),0_0_15px_rgba(245,158,11,0.15)]',
            'icon_color' => 'text-[#f59e0b]',
            'title_color' => 'text-white',
            'desc_color' => 'text-[#9ca3af]',
            'icon' => 'triangle-alert',
        ],
        'destructive' => [
            'container' => 'bg-[#160a0a] border border-[#ef4444]/35 text-white shadow-[0_10px_30px_rgba(0,0,0,0.5),0_0_15px_rgba(239,68,68,0.15)]',
            'icon_color' => 'text-[#ef4444]',
            'title_color' => 'text-white',
            'desc_color' => 'text-[#9ca3af]',
            'icon' => 'circle-x',
        ],
        'error' => [
            'container' => 'bg-[#160a0a] border border-[#ef4444]/35 text-white shadow-[0_10px_30px_rgba(0,0,0,0.5),0_0_15px_rgba(239,68,68,0.15)]',
            'icon_color' => 'text-[#ef4444]',
            'title_color' => 'text-white',
            'desc_color' => 'text-[#9ca3af]',
            'icon' => 'circle-x',
        ],
    ];

    $config = $styles[$variant] ?? $styles['info'];
@endphp

<div {{ $attributes->merge(['class' => 'relative w-full rounded-[12px] p-4 transition-all duration-200 ' . $config['container']]) }}
     role="alert"
     @if($dismissible) x-data="{ open: true }" x-show="open" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @endif>
    
    <div class="flex items-start gap-3">
        {{-- Left Icon --}}
        <div class="flex-shrink-0 mt-0.5 {{ $config['icon_color'] }}">
            @if(isset($icon))
                {{ $icon }}
            @elseif($config['icon'] === 'circle-alert')
                {{-- Lucide CircleAlertIcon --}}
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
            @elseif($config['icon'] === 'circle-check')
                {{-- Lucide CircleCheck --}}
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
            @elseif($config['icon'] === 'triangle-alert')
                {{-- Lucide TriangleAlert --}}
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            @elseif($config['icon'] === 'circle-x')
                {{-- Lucide CircleX --}}
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="m15 9-6 6" />
                    <path d="m9 9 6 6" />
                </svg>
            @endif
        </div>

        {{-- Content: AlertTitle & AlertDescription --}}
        <div class="flex-1 min-w-0 pr-2">
            @if($title || isset($titleSlot))
                <h5 class="font-heading font-semibold text-sm leading-snug tracking-normal {{ $config['title_color'] }}">
                    {{ $title ?? $titleSlot }}
                </h5>
            @endif

            <div class="font-sans text-xs md:text-sm leading-relaxed mt-0.5 {{ $config['desc_color'] }}">
                {{ $description ?? $slot }}
            </div>
        </div>

        {{-- Optional Dismiss Button --}}
        @if($dismissible)
            <button type="button"
                    @click="open = false"
                    class="flex-shrink-0 -mr-1 -mt-1 p-1 text-gray-400 hover:text-white transition-colors rounded hover:bg-white/10 cursor-pointer"
                    aria-label="Close alert">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
