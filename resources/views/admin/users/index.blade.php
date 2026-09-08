<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foydalanuvchilar') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap gap-2 text-sm">
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-md border {{ !$currentRole ? 'bg-gray-800 text-white border-gray-800' : 'bg-white border-gray-300 text-gray-700' }}">Barchasi</a>
                    @foreach ($roles as $key => $label)
                        <a href="{{ route('admin.users.index', ['role' => $key]) }}" class="px-3 py-1.5 rounded-md border {{ $currentRole === $key ? 'bg-gray-800 text-white border-gray-800' : 'bg-white border-gray-300 text-gray-700' }}">{{ $label }}</a>
                    @endforeach
                </div>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                    + Foydalanuvchi qo'shish
                </a>
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Ism</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Telefon</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Rol</th>
                            <th class="px-5 py-2 text-left font-medium text-gray-500">Holat</th>
                            <th class="px-5 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-5 py-3">{{ $user->full_name }}</td>
                                <td class="px-5 py-3">{{ $user->phone }}</td>
                                <td class="px-5 py-3">{{ $roles[$user->roles->first()?->name] ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <x-status-badge :status="$user->is_active ? 'faol' : 'nofaol'" />
                                </td>
                                <td class="px-5 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-600 hover:underline">Tahrirlash</a>
                                    @if ($user->is_active)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Foydalanuvchini nofaollashtirishni tasdiqlaysizmi?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Nofaollashtirish</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-gray-500">Foydalanuvchilar topilmadi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-3">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
