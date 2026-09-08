<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loyihalarim') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if ($projects->isEmpty())
                <div class="bg-white rounded-lg border border-gray-200 p-10 text-center text-gray-500">
                    Sizda hali loyihalar yo'q.
                    <a href="{{ route('apply.create') }}" class="text-indigo-600 hover:underline">Ariza topshiring</a>.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="block bg-white rounded-lg border border-gray-200 p-5 hover:border-gray-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-medium text-gray-900">{{ $project->applicationType->name }}</h3>
                                <x-status-badge :status="$project->status" />
                            </div>
                            <x-progress-bar :percent="$project->progress_percent" />
                            <p class="text-xs text-gray-400 mt-3">{{ $project->created_at->format('d.m.Y') }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
