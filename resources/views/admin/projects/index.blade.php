<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barcha loyihalar') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <form method="GET" class="bg-white rounded-lg border border-gray-200 p-4 flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Holat</label>
                    <select name="status" class="border-gray-300 rounded-md text-sm">
                        <option value="">Barchasi</option>
                        @foreach (['jarayonda' => 'Jarayonda', 'yakunlangan' => 'Yakunlangan', 'bekor_qilingan' => 'Bekor qilingan'] as $key => $label)
                            <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Ariza turi</label>
                    <select name="application_type_id" class="border-gray-300 rounded-md text-sm">
                        <option value="">Barchasi</option>
                        @foreach ($applicationTypes as $type)
                            <option value="{{ $type->id }}" @selected(($filters['application_type_id'] ?? '') == $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Mas'ul xodim</label>
                    <select name="responsible_user_id" class="border-gray-300 rounded-md text-sm">
                        <option value="">Barchasi</option>
                        @foreach ($staff as $member)
                            <option value="{{ $member->id }}" @selected(($filters['responsible_user_id'] ?? '') == $member->id)>{{ $member->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md">Filtrlash</button>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500">Tozalash</a>
            </form>

            <div class="bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Izlanuvchi</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Ariza turi</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Holat</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Progress</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Sana</th>
                            <th class="px-5 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-5 py-3">{{ $project->user->full_name }}</td>
                                <td class="px-5 py-3">{{ $project->applicationType->name }}</td>
                                <td class="px-5 py-3"><x-status-badge :status="$project->status" /></td>
                                <td class="px-5 py-3 w-40"><x-progress-bar :percent="$project->progress_percent" /></td>
                                <td class="px-5 py-3 text-gray-500">{{ $project->created_at->format('d.m.Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:underline">Ko'rish</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-6 text-center text-gray-500">Loyihalar topilmadi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-3">{{ $projects->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
