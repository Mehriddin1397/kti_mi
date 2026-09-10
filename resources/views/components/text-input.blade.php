@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/15 rounded-xl shadow-2xs text-slate-800 placeholder:text-slate-400 text-sm transition-all duration-150 disabled:bg-slate-50 disabled:text-slate-400']) }}>
