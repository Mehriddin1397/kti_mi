<?php

namespace Tests\Feature;

use App\Livewire\ProjectBoard;
use App\Models\ApplicationType;
use App\Models\Project;
use App\Models\ProjectStage;
use App\Models\ProjectTask;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectBoardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RoleSeeder::class);
        Storage::fake('local');
    }

    public function test_applicant_can_upload_and_staff_can_reject_then_approve(): void
    {
        $applicant = User::factory()->create();
        $applicant->assignRole(Roles::IZLANUVCHI);

        $staff = User::factory()->create();
        $staff->assignRole(Roles::MASUL_XODIM);

        $type = ApplicationType::create(['name' => 'Test turi', 'is_active' => true]);

        $project = Project::create([
            'application_type_id' => $type->id,
            'user_id' => $applicant->id,
            'full_name' => $applicant->full_name,
            'phone' => $applicant->phone,
            'status' => 'jarayonda',
            'progress_percent' => 0,
        ]);

        $stage = ProjectStage::create([
            'project_id' => $project->id,
            'name' => 'Bosqich 1',
            'order' => 1,
            'status' => 'kutilmoqda',
        ]);

        $task = ProjectTask::create([
            'project_stage_id' => $stage->id,
            'name' => 'Hujjat yuklash',
            'responsible_user_id' => $staff->id,
            'status' => 'kutilmoqda',
            'order' => 1,
        ]);

        // Applicant uploads a document.
        Livewire::actingAs($applicant)
            ->test(ProjectBoard::class, ['project' => $project])
            ->set('file', UploadedFile::fake()->create('hujjat.pdf', 100))
            ->call('uploadDocument', $task->id)
            ->assertHasNoErrors();

        $task->refresh();
        $this->assertSame('jarayonda', $task->status);
        $this->assertCount(1, $task->documents);
        $this->assertSame(1, $task->documents->first()->version);

        // Staff rejects with a comment.
        Livewire::actingAs($staff)
            ->test(ProjectBoard::class, ['project' => $project])
            ->set('rejectComment', 'Skan sifatsiz, qayta yuklang.')
            ->call('reject', $task->id)
            ->assertHasNoErrors();

        $task->refresh();
        $this->assertSame('qaytarildi', $task->status);
        $this->assertCount(1, $task->comments);
        $project->refresh();
        $this->assertSame(0, $project->progress_percent);

        // Applicant re-uploads (new version).
        Livewire::actingAs($applicant)
            ->test(ProjectBoard::class, ['project' => $project])
            ->set('file', UploadedFile::fake()->create('hujjat-v2.pdf', 100))
            ->call('uploadDocument', $task->id)
            ->assertHasNoErrors();

        $task->refresh();
        $this->assertSame('jarayonda', $task->status);
        $this->assertCount(2, $task->documents);
        $this->assertSame(2, $task->documents->first()->version);

        // Staff approves.
        Livewire::actingAs($staff)
            ->test(ProjectBoard::class, ['project' => $project])
            ->call('approve', $task->id)
            ->assertHasNoErrors();

        $task->refresh();
        $project->refresh();
        $this->assertSame('tasdiqlandi', $task->status);
        $this->assertSame(100, $project->progress_percent);
        $this->assertSame('yakunlangan', $project->status);
    }

    public function test_applicant_cannot_review_a_task_assigned_to_staff(): void
    {
        $applicant = User::factory()->create();
        $applicant->assignRole(Roles::IZLANUVCHI);

        $staff = User::factory()->create();
        $staff->assignRole(Roles::MASUL_XODIM);

        $type = ApplicationType::create(['name' => 'Test turi', 'is_active' => true]);

        $project = Project::create([
            'application_type_id' => $type->id,
            'user_id' => $applicant->id,
            'full_name' => $applicant->full_name,
            'phone' => $applicant->phone,
            'status' => 'jarayonda',
            'progress_percent' => 0,
        ]);

        $stage = ProjectStage::create([
            'project_id' => $project->id,
            'name' => 'Bosqich 1',
            'order' => 1,
            'status' => 'kutilmoqda',
        ]);

        $task = ProjectTask::create([
            'project_stage_id' => $stage->id,
            'name' => 'Hujjat yuklash',
            'responsible_user_id' => $staff->id,
            'status' => 'jarayonda',
            'order' => 1,
        ]);

        Livewire::actingAs($applicant)
            ->test(ProjectBoard::class, ['project' => $project])
            ->call('approve', $task->id)
            ->assertForbidden();
    }
}
