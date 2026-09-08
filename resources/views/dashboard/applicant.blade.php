<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loyihalarim') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-end">
                <a href="{{ route('apply.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                    + Yangi ariza topshirish
                </a>
            </div>

            @if ($projects->isEmpty())
                <div class="bg-white rounded-lg border border-gray-200 p-10 text-center text-gray-500">
                    Sizda hali loyihalar yo'q. Yangi ariza topshiring.
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
