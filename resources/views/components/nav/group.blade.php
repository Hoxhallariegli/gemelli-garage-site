@props([
    'label' => '',
    'icon' => '',
    'route' => ''
] )

@php
    $openState = Route::is($route . '*')
        ? '{ isOpen: true }'
        : '{ isOpen: false }';
@endphp

<div class="block" x-data="{{ $openState }}">
    <div
        @click="isOpen = !isOpen"
        class="flex cursor-pointer items-center justify-between rounded-md px-2 py-2 text-gray-700 hover:bg-blue-50 hover:text-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-gray-100"
    >
        <div class="flex gap-2.5">
            @if ($icon)
                <span class="flex flex-none items-center">
                    <x-dynamic-component
                        :component="'heroicon-o-' . $icon"
                        class="size-5 text-gray-400 group-hover:text-blue-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                    />
                </span>
            @endif

            <span>{{ $label }}</span>
        </div>

        <svg
            x-cloak
            x-show="isOpen"
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
            />
        </svg>

        <svg
            x-cloak
            x-show="!isOpen"
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </div>

    <div x-cloak x-show="isOpen" class="text-sm">
        {{ $slot }}
    </div>
</div>
