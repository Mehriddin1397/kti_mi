<div class="space-y-6">
    <div class="bg-white rounded-lg border border-gray-200 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h3 class="font-medium text-gray-900">{{ $project->applicationType->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $project->user->full_name }} &middot; {{ $project->phone }}</p>
            </div>
            <x-status-badge :status="$project->status" />
        </div>
        <div class="mt-4 max-w-md">
            <x-progress-bar :percent="$project->progress_percent" />
        </div>
    </div>

    @foreach ($project->stages as $stage)
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h4 class="font-medium text-gray-900">{{ $stage->order }}. {{ $stage->name }}</h4>
                <x-status-badge :status="$stage->status" />
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($stage->tasks as $task)
                    @php
                        $canUpload = Auth::user()->can('upload', $task);
                        $canReview = Auth::user()->can('review', $task);
                        $isOpen = $openTaskId === $task->id;
                    @endphp

                    <div class="px-5 py-4">
                        <button type="button" wire:click="toggleTask({{ $task->id }})" class="w-full flex items-center justify-between text-left">
                            <div>
                                <p class="font-medium text-gray-800">{{ $task->name }}</p>
                                @if ($task->responsibleUser)
                                    <p class="text-xs text-gray-400 mt-0.5">Mas'ul: {{ $task->responsibleUser->full_name }}</p>
                                @endif
                            </div>
                            <x-status-badge :status="$task->status" />
                        </button>

                        @if ($isOpen)
                            <div class="mt-4 space-y-4 border-t border-gray-100 pt-4">
                                @if ($task->description)
                                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                @endif

                                {{-- Hujjatlar tarixi --}}
                                @if ($task->documents->isNotEmpty())
                                    <div class="space-y-2">
                                        <p class="text-xs font-medium text-gray-500 uppercase">Yuklangan hujjatlar</p>
                                        @foreach ($task->documents as $document)
                                            <div class="flex items-center justify-between text-sm bg-gray-50 rounded px-3 py-2">
                                                <span>v{{ $document->version }} — {{ $document->file_name }}</span>
                                                <div class="flex items-center gap-3">
                                                    <x-status-badge :status="$document->status" />
                                                    <a href="{{ route('documents.download', $document) }}" class="text-indigo-600 hover:underline text-xs">Yuklab olish</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Izohlar (rad etish sabablari) --}}
                                @if ($task->comments->isNotEmpty())
                                    <div class="space-y-2">
                                        <p class="text-xs font-medium text-gray-500 uppercase">Izohlar</p>
                                        @foreach ($task->comments as $comment)
                                            <div class="text-sm bg-red-50 border border-red-100 rounded px-3 py-2">
                                                <p class="text-gray-700">{{ $comment->text }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ $comment->user->full_name }} &middot; {{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Hujjat yuklash --}}
                                @if ($canUpload && $task->status !== 'tasdiqlandi')
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase mb-2">Hujjat yuklash</p>
                                        <input type="file" wire:model="file" class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-gray-100 file:text-gray-700" />
                                        @error('file') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                        <div wire:loading wire:target="file" class="text-xs text-gray-400 mt-1">Yuklanmoqda...</div>
                                        <x-primary-button class="mt-2" wire:click="uploadDocument({{ $task->id }})" wire:loading.attr="disabled">
                                            Saqlash
                                        </x-primary-button>
                                    </div>
                                @endif

                                {{-- Tasdiqlash / rad etish --}}
                                @if ($canReview && $task->status === 'jarayonda')
                                    <div class="flex flex-wrap items-start gap-3">
                                        <x-primary-button wire:click="approve({{ $task->id }})" wire:loading.attr="disabled">
                                            Tasdiqlash
                                        </x-primary-button>

                                        <div class="flex-1 min-w-[220px]">
                                            <textarea wire:model="rejectComment" rows="2" placeholder="Rad etish sababi..." class="block w-full text-sm border-gray-300 rounded-md shadow-sm"></textarea>
                                            @error('rejectComment') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                            <x-danger-button class="mt-2" wire:click="reject({{ $task->id }})" wire:loading.attr="disabled">
                                                Rad etish
                                            </x-danger-button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
