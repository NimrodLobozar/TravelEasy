@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 bg-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 py-1']) }}>
