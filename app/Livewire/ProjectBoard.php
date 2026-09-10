<?php

namespace App\Livewire;

use App\Contracts\SmsServiceInterface;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectBoard extends Component
{
    use WithFileUploads;

    public Project $project;

    public ?int $openTaskId = null;

    public $file = null;

    #[Validate('required|string|max:2000')]
    public string $rejectComment = '';

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function toggleTask(int $taskId): void
    {
        $this->openTaskId = $this->openTaskId === $taskId ? null : $taskId;
        $this->reset('file', 'rejectComment');
        $this->resetErrorBag();
    }

    public function uploadDocument(int $taskId): void
    {
        $task = ProjectTask::with('stage.project')->findOrFail($taskId);

        abort_unless(Auth::user()->can('upload', $task), 403);
        abort_if($task->status === 'tasdiqlandi', 422);

        $this->validate([
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $path = $this->file->store('documents/' . $task->id, 'local');

        $nextVersion = $task->documents()->max('version') + 1;

        $task->documents()->create([
            'uploaded_by' => Auth::id(),
            'file_name' => $this->file->getClientOriginalName(),
            'file_path' => $path,
            'version' => $nextVersion,
            'status' => 'kutilmoqda',
        ]);

        $task->update(['status' => 'jarayonda']);

        if ($task->responsible_user_id) {
            $reviewer = $task->responsibleUser;
            app(SmsServiceInterface::class)->send(
                $reviewer->phone,
                "Yangi hujjat yuklandi: \"{$task->name}\" vazifasini ko'rib chiqing.",
                $reviewer
            );
        }

        $this->reset('file');
        $this->project->refresh();
        session()->flash('status', "Hujjat muvaffaqiyatli yuklandi.");
    }

    public function approve(int $taskId): void
    {
        $task = ProjectTask::with('stage.project.user')->findOrFail($taskId);

        abort_unless(Auth::user()->can('review', $task), 403);
        abort_unless($task->status === 'jarayonda' && $task->latestDocument, 422);

        $task->update([
            'status' => 'tasdiqlandi',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $task->latestDocument?->update(['status' => 'tasdiqlangan']);

        $this->project->recalculateProgress();
        $this->project->refresh();

        $applicant = $task->stage->project->user;
        app(SmsServiceInterface::class)->send(
            $applicant->phone,
            "Vazifa tasdiqlandi: \"{$task->name}\".",
            $applicant
        );

        $this->openTaskId = null;
        session()->flash('status', 'Vazifa tasdiqlandi.');
    }

    public function reject(int $taskId): void
    {
        $task = ProjectTask::with('stage.project.user')->findOrFail($taskId);

        abort_unless(Auth::user()->can('review', $task), 403);
        abort_unless($task->status === 'jarayonda' && $task->latestDocument, 422);

        $this->validate([
            'rejectComment' => ['required', 'string', 'max:2000'],
        ]);

        $task->update([
            'status' => 'qaytarildi',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        $task->latestDocument?->update(['status' => 'rad_etilgan']);

        $task->comments()->create([
            'document_id' => $task->latestDocument?->id,
            'user_id' => Auth::id(),
            'text' => $this->rejectComment,
        ]);

        $this->project->recalculateProgress();
        $this->project->refresh();

        $applicant = $task->stage->project->user;
        app(SmsServiceInterface::class)->send(
            $applicant->phone,
            'Hurmatli mustaqil izlanuvchi! Hujjatingiz rad etildi. Batafsil malumot shaxsiy kabinetingizda.',
            $applicant
        );

        $this->reset('rejectComment');
        $this->openTaskId = null;
        session()->flash('status', 'Vazifa rad etildi.');
    }

    public function render()
    {
        $this->project->load([
            'stages.tasks.responsibleUser',
            'stages.tasks.latestDocument',
            'stages.tasks.comments.user',
        ]);

        return view('livewire.project-board');
    }
}
