@props(['color' => '', 'type' => 'button'])

@php
    $colors = [
        'cyan' => ['text' => 'text-cyan-500', 'hover' => 'hover:bg-cyan-500', 'active' => 'active:bg-cyan-500/70'],
        'yellow' => ['text' => 'text-yellow-500', 'hover' => 'hover:bg-yellow-500', 'active' => 'active:bg-yellow-500/70'],
        'red' => ['text' => 'text-red-500', 'hover' => 'hover:bg-red-500', 'active' => 'active:bg-red-500/70'],
        'black-main' => ['text' => 'text-white-main', 'hover' => 'hover:bg-black-main/70', 'active' => 'active:bg-black-main'],
    ];

    $textColor = $colors[$color]['text'] ?? 'text-gray-500';
    $hoverBgColor = $colors[$color]['hover'] ?? 'hover:bg-gray-500';
    $activeBgColor = $colors[$color]['active'] ?? 'active:bg-gray-500';

    $attributes = $attributes->merge([
        'class' => "p-1 {{ $textColor }} rounded-md {{ $hoverBgColor }} hover:text-white {{ $activeBgColor }} transition cursor-pointer"
    ]);
@endphp

<button type="{{ $type }}" {{ $attributes }}>{{ $slot }}</button>