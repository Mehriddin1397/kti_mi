<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menga biriktirilgan vazifalar') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-wrap gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-md border {{ !$currentStatus ? 'bg-gray-800 text-white border-gray-800' : 'bg-white border-gray-300 text-gray-700' }}">
                    Barchasi
                </a>
                @foreach (['kutilmoqda' => 'Kutilmoqda', 'jarayonda' => 'Jarayonda', 'qaytarildi' => 'Qaytarildi', 'tasdiqlandi' => 'Tasdiqlandi'] as $key => $label)
                    <a href="{{ route('dashboard', ['status' => $key]) }}" class="px-3 py-1.5 rounded-md border {{ $currentStatus === $key ? 'bg-gray-800 text-white border-gray-800' : 'bg-white border-gray-300 text-gray-700' }}">
                        {{ $label }} ({{ $counts[$key] }})
                    </a>
                @endforeach
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Vazifa</th>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Izlanuvchi</th>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Holat</th>
                                <th class="px-5 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tasks as $task)
                                <tr>
                                    <td class="px-5 py-3">{{ $task->name }}</td>
                                    <td class="px-5 py-3">{{ $task->stage->project->user->full_name }}</td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$task->status" />
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('projects.show', $task->stage->project) }}" class="text-indigo-600 hover:underline">Ko'rish</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-center text-gray-500">Vazifalar topilmadi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3">
                    {{ $tasks->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
