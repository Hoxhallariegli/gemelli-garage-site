@props([
    'variant' => 'white',
    'label' => '',
    'value' => '',
    'labelColor' => null,
    'valueColor' => null,
])

@php
$baseClasses = "p-4 rounded-[1.5rem] text-center transition-all ";
$variantClasses = match($variant) {
    'white' => "bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-sm",
    'blue' => "bg-blue-600 dark:bg-blue-500 text-white shadow-lg shadow-blue-500/20",
    'slate' => "bg-slate-900 dark:bg-slate-700 text-white shadow-lg shadow-slate-900/10",
    default => "bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700"
};

$labelClass = $labelColor ?? match($variant) {
    'blue' => "text-blue-100",
    'slate' => "text-slate-400",
    default => "text-gray-400 dark:text-gray-400"
};

$valueClass = $valueColor ?? match($variant) {
    'blue', 'slate' => "text-white",
    default => "text-gray-900 dark:text-white"
};
@endphp

<div {{ $attributes->merge(['class' => $baseClasses . $variantClasses]) }}>
    <span class="block text-[8px] font-black uppercase tracking-widest mb-1 {{ $labelClass }}">{{ $label }}</span>
    <span class="text-sm font-black italic tracking-tight {{ $valueClass }}">{{ $value }}</span>
    {{ $slot }}
</div>
