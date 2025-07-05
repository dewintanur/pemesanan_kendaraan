@props(['title', 'value', 'icon', 'color'])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'red' => 'bg-red-100 text-red-600',
];
@endphp

<div class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-4">
    <div class="{{ $colors[$color] ?? 'bg-gray-100 text-gray-600' }} p-3 rounded-full">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
        </svg>
    </div>
    <div>
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <h3 class="text-xl font-bold text-gray-800">{{ $value }}</h3>
    </div>
</div>
