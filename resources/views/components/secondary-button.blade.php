<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 active:bg-slate-100 text-slate-700 font-medium text-sm rounded-xl shadow-xs focus:outline-none focus:ring-4 focus:ring-slate-200/60 transition-all duration-150 disabled:opacity-50 disabled:pointer-events-none cursor-pointer']) }}>
    {{ $slot }}
</button>
