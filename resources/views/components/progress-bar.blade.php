@props(['percent' => 0])

<div class="flex items-center gap-2">
    <div class="flex-1 bg-gray-200 rounded-full h-2.5 overflow-hidden">
        <div class="bg-indigo-600 h-2.5 rounded-full transition-all" style="width: {{ (int) $percent }}%"></div>
    </div>
    <span class="text-xs font-medium text-gray-600 w-9 text-right">{{ (int) $percent }}%</span>
</div>
