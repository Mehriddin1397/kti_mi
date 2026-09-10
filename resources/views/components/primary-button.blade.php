<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-xl shadow-xs shadow-indigo-500/20 hover:shadow-md hover:shadow-indigo-500/25 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 active:scale-[0.99] transition-all duration-150 disabled:opacity-50 disabled:pointer-events-none cursor-pointer']) }}>
    {{ $slot }}
</button>
