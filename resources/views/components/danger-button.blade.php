<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-medium text-sm rounded-xl shadow-xs shadow-rose-500/20 hover:shadow-md hover:shadow-rose-500/25 focus:outline-none focus:ring-4 focus:ring-rose-500/20 active:scale-[0.99] transition-all duration-150 disabled:opacity-50 disabled:pointer-events-none cursor-pointer']) }}>
    {{ $slot }}
</button>
