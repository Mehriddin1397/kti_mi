<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin panel') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Jami loyihalar</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalProjects }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Jarayonda</p>
                    <p class="text-2xl font-semibold text-blue-600">{{ $activeProjects }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Yakunlangan</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $finishedProjects }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Foydalanuvchilar</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.application-types.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                    + Ariza turi qo'shish
                </a>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                    + Foydalanuvchi qo'shish
                </a>
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                    Barcha loyihalar
                </a>
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="font-medium text-gray-900">So'nggi loyihalar</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Izlanuvchi</th>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Ariza turi</th>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Holat</th>
                                <th class="px-5 py-2 text-left font-medium text-gray-500">Progress</th>
                                <th class="px-5 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($recentProjects as $project)
                                <tr>
                                    <td class="px-5 py-3">{{ $project->user->full_name }}</td>
                                    <td class="px-5 py-3">{{ $project->applicationType->name }}</td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$project->status" />
                                    </td>
                                    <td class="px-5 py-3 w-40">
                                        <x-progress-bar :percent="$project->progress_percent" />
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:underline">Ko'rish</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-gray-500">Hozircha loyihalar yo'q.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
