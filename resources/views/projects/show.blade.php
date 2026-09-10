<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
                <span>/</span>
                <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 transition">Loyihalarim</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md">{{ $project->applicationType->name }}</span>
            </div>
            <div class="flex items-center gap-2">
                <x-status-badge :status="$project->status" />
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @livewire('project-board', ['project' => $project])
        </div>
    </div>
</x-app-layout>
