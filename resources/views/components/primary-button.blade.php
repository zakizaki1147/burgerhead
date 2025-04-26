@props(['color' => '', 'type' => 'button'])

@php
    $colors = [
        'red-main' => ['bg' => 'bg-red-main', 'border' => 'border-red-main', 'hover' => 'hover:bg-red-main/85', 'active' => 'active:bg-red-main'],
        'yellow-main' => ['bg' => 'bg-yellow-main', 'border' => 'border-yellow-main', 'hover' => 'hover:bg-yellow-main/85', 'active' => 'active:bg-yellow-main'],
    ];

    $bgColor = $colors[$color]['bg'] ?? 'bg-gray-500';
    $borderColor = $colors[$color]['border'] ?? 'border-gray-500';
    $hoverBgColor = $colors[$color]['hover'] ?? 'hover:bg-gray-500';
    $activeBgColor = $colors[$color]['active'] ?? 'active:bg-gray-500';

    $attributes = $attributes->merge([
        'class' => "{ $bgColor } border-2 { $borderColor } px-3 py-2 w-full text-white-main text-sm font-bold flex justify-center items-center gap-2 rounded-md { $hoverBgColor } { $activeBgColor } transition cursor-pointer"
    ]);
@endphp

<button type="{{ $type }}" {{ $attributes }}>{{ $slot }}</button>