@props([
    'label' => null,
    'placeholder' => '',
    'rows' => 3,
    'error' => null,
])

<div class="w-full">
    @if($label)
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
            {{ $label }}
        </label>
    @endif

    <textarea 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}" 
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2.5 rounded-xl border ' . 
            ($error ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200 dark:border-slate-700') . 
            ' bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-600 text-sm focus:outline-none focus:ring-2 ' . 
            ($error ? 'focus:ring-rose-500' : 'focus:ring-indigo-500/50') . 
            ' focus:border-indigo-500 transition-all duration-200 resize-y'
        ]) }}
    >{{ $slot }}</textarea>

    @if($error)
        <p class="mt-1 text-xs text-rose-500">{{ $error }}</p>
    @endif
</div>
