<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ariza turlari') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('admin.application-types.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                    + Yangi ariza turi
                </a>
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Nomi</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Bosqichlar</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Loyihalar</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Holat</th>
                            <th class="px-5 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($applicationTypes as $type)
                            <tr>
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.application-types.show', $type) }}" class="text-indigo-600 hover:underline font-medium">{{ $type->name }}</a>
                                </td>
                                <td class="px-5 py-3">{{ $type->stages_count }}</td>
                                <td class="px-5 py-3">{{ $type->projects_count }}</td>
                                <td class="px-5 py-3">
                                    <x-status-badge :status="$type->is_active ? 'faol' : 'nofaol'" />
                                </td>
                                <td class="px-5 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.application-types.edit', $type) }}" class="text-gray-600 hover:underline">Tahrirlash</a>
                                    <form method="POST" action="{{ route('admin.application-types.destroy', $type) }}" class="inline" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">O'chirish</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-gray-500">Hozircha ariza turlari yo'q.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
