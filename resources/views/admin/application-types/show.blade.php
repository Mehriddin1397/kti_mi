<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $applicationType->name }}
            </h2>
            <a href="{{ route('admin.application-types.edit', $applicationType) }}" class="text-sm text-gray-500 hover:underline">Ariza turini tahrirlash</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <p class="text-sm text-gray-500">
                Bu yerda ariza turi uchun bosqichlar va vazifalar shablonini sozlaysiz. Izlanuvchi ariza topshirganda,
                shu shablondan nusxa olinib, yangi loyiha yaratiladi — shablonni keyinchalik o'zgartirsangiz, allaqachon yaratilgan loyihalarga ta'sir qilmaydi.
            </p>

            @forelse ($applicationType->stages as $stage)
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-4">
                        <form method="POST" action="{{ route('admin.application-types.stages.update', [$applicationType, $stage]) }}" class="flex items-center gap-2 flex-1">
                            @csrf @method('PUT')
                            <span class="text-sm text-gray-400 w-6">{{ $stage->order }}.</span>
                            <input type="text" name="name" value="{{ $stage->name }}" class="border-gray-300 rounded-md text-sm flex-1">
                            <input type="number" name="order" value="{{ $stage->order }}" class="border-gray-300 rounded-md text-sm w-20">
                            <button type="submit" class="text-sm text-indigo-600 hover:underline">Saqlash</button>
                        </form>
                        <form method="POST" action="{{ route('admin.application-types.stages.destroy', [$applicationType, $stage]) }}" onsubmit="return confirm('Bosqichni o\'chirishni tasdiqlaysizmi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:underline">O'chirish</button>
                        </form>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach ($stage->tasks as $task)
                            <div class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.tasks.update', $task) }}" class="flex flex-wrap items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $task->name }}" placeholder="Vazifa nomi" class="border-gray-300 rounded-md text-sm flex-1 min-w-[160px]">
                                    <input type="text" name="description" value="{{ $task->description }}" placeholder="Tavsif" class="border-gray-300 rounded-md text-sm flex-1 min-w-[160px]">
                                    <select name="default_responsible_user_id" class="border-gray-300 rounded-md text-sm">
                                        <option value="">Izlanuvchining o'zi</option>
                                        @foreach ($staff as $member)
                                            <option value="{{ $member->id }}" @selected($task->default_responsible_user_id == $member->id)>{{ $member->full_name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="order" value="{{ $task->order }}" class="border-gray-300 rounded-md text-sm w-16">
                                    <button type="submit" class="text-sm text-indigo-600 hover:underline">Saqlash</button>
                                </form>
                                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Vazifani o\'chirishni tasdiqlaysizmi?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:underline mt-1">O'chirish</button>
                                </form>
                            </div>
                        @endforeach

                        <div class="px-5 py-3 bg-gray-50">
                            <form method="POST" action="{{ route('admin.stages.tasks.store', $stage) }}" class="flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="text" name="name" placeholder="Yangi vazifa nomi" required class="border-gray-300 rounded-md text-sm flex-1 min-w-[160px]">
                                <input type="text" name="description" placeholder="Tavsif (ixtiyoriy)" class="border-gray-300 rounded-md text-sm flex-1 min-w-[160px]">
                                <select name="default_responsible_user_id" class="border-gray-300 rounded-md text-sm">
                                    <option value="">Izlanuvchining o'zi</option>
                                    @foreach ($staff as $member)
                                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="text-sm text-white bg-gray-800 px-3 py-1.5 rounded-md">+ Vazifa</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-8 text-center text-gray-500">
                    Hali bosqichlar qo'shilmagan.
                </div>
            @endforelse

            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <form method="POST" action="{{ route('admin.application-types.stages.store', $applicationType) }}" class="flex items-center gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Yangi bosqich nomi" required class="border-gray-300 rounded-md text-sm flex-1">
                    <button type="submit" class="text-sm text-white bg-gray-800 px-3 py-1.5 rounded-md">+ Bosqich qo'shish</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
