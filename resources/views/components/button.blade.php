@props([
    'type' => 'submit',
    'variant' => 'default',
    'size' => 'default',
    'disabled' => false,
])

@php
$class = "inline-flex items-center justify-center font-semibold disabled:opacity-50
disabled:cursor-not-allowed rounded-2xl cursor-pointer transition-none ";

$class .= " " . match($variant) {
    default => "bg-gray-900 text-white dark:bg-white dark:text-gray-900 shadow-sm hover:opacity-90",
    'slate' => "bg-slate-900 hover:bg-slate-800 text-white shadow-xl shadow-slate-900/10 transition-all font-black uppercase tracking-widest",
    'primary' => "bg-primary text-white shadow-sm hover:opacity-90",
    'gray' => "bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200",
    'red' => "bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100",
    'green' => "bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400 hover:bg-green-100",
    'blue' => "bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 hover:bg-blue-100",
    'link' => "text-primary hover:underline p-0 !bg-transparent"
};

$class .= " " . match($size){
    default => "px-5 py-3 text-[10px]",
    'xs' => "px-2 py-1 text-[8px]",
    'sm' => "px-3 py-2 text-[9px]",
    'lg' => "px-8 py-4 text-xs",
    'icon' => "size-10 p-0"
};
@endphp

<button
    type="{{ $type }}"
    @disabled($disabled)
    {{$attributes->merge(["class" => $class])->except(['size', 'variant'])}}
    >
    {{$slot}}
</button>
