@props(['color' => '', 'type' => 'button'])

@php
    $colors = [
        'red-main' => ['bg' => 'bg-red-main/25', 'border' => 'border-red-main', 'text' => 'text-red-main', 'hover' => 'hover:bg-red-main', 'active' => 'active:bg-red-main/85'],
        'yellow-main' => ['bg' => 'bg-yellow-main/25', 'border' => 'border-yellow-main', 'text' => 'text-yellow-main', 'hover' => 'hover:bg-yellow-main', 'active' => 'active:bg-yellow-main/85'],
    ];

    $bgColor = $colors[$color]['bg'] ?? 'bg-gray-500';
    $borderColor = $colors[$color]['border'] ?? 'border-gray-500';
    $textColor = $colors[$color]['text'] ?? 'text-gray-500';
    $hoverBgColor = $colors[$color]['hover'] ?? 'hover:bg-gray-500';
    $activeBgColor = $colors[$color]['active'] ?? 'hover:bg-gray-500';

    $attributes = $attributes->merge([
        'class' => "{$bgColor} border-2 {$borderColor} px-3 py-2 w-full {$textColor} text-sm font-bold flex justify-center items-center gap-2 rounded-md {$hoverBgColor} hover:text-white-main {$activeBgColor} transition cursor-pointer"
    ]);
@endphp

<button type="{{ $type }}" {{ $attributes }}>{{ $slot }}</button>