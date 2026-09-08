<?php

namespace Tests\Feature;

use App\Models\ApplicationType;
use App\Models\ApplicationTypeStage;
use App\Models\ApplicationTypeTask;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_submitting_an_application_copies_the_template_into_a_new_project(): void
    {
        $applicant = User::factory()->create();
        $applicant->assignRole(Roles::IZLANUVCHI);

        $type = ApplicationType::create(['name' => 'Doktorantura', 'is_active' => true]);
        $stage = ApplicationTypeStage::create(['application_type_id' => $type->id, 'name' => 'Hujjatlar', 'order' => 1]);
        ApplicationTypeTask::create(['application_type_stage_id' => $stage->id, 'name' => 'Pasport', 'order' => 1]);
        ApplicationTypeTask::create(['application_type_stage_id' => $stage->id, 'name' => 'Diplom', 'order' => 2]);

        $response = $this->actingAs($applicant)->post("/apply/{$type->id}", [
            'full_name' => 'Aziz Yusupov',
            'phone' => '+998900000000',
        ]);

        $project = $applicant->projects()->first();

        $response->assertRedirect(route('projects.show', $project));
        $this->assertNotNull($project);
        $this->assertSame(0, $project->progress_percent);
        $this->assertCount(1, $project->stages);
        $this->assertCount(2, $project->stages->first()->tasks);

        // Changing the template afterwards must not affect the already-created project.
        ApplicationTypeTask::create(['application_type_stage_id' => $stage->id, 'name' => 'Malaka oshirish sertifikati', 'order' => 3]);
        $this->assertCount(2, $project->stages->first()->refresh()->tasks);
    }

    public function test_staff_cannot_submit_an_application(): void
    {
        $staff = User::factory()->create();
        $staff->assignRole(Roles::MASUL_XODIM);

        $type = ApplicationType::create(['name' => 'Doktorantura', 'is_active' => true]);

        $this->actingAs($staff)
            ->post("/apply/{$type->id}", ['full_name' => 'X', 'phone' => '+998900000000'])
            ->assertForbidden();
    }
}
