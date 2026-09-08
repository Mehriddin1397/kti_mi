<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_type_id',
        'user_id',
        'full_name',
        'phone',
        'status',
        'progress_percent',
    ];

    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stages()
    {
        return $this->hasMany(ProjectStage::class)->orderBy('order');
    }

    public function tasks()
    {
        return $this->hasManyThrough(ProjectTask::class, ProjectStage::class);
    }

    public function recalculateProgress(): void
    {
        $totalTasks = $this->tasks()->count();
        $approvedTasks = $this->tasks()->where('project_tasks.status', 'tasdiqlandi')->count();

        $percent = $totalTasks > 0
            ? (int) round(($approvedTasks / $totalTasks) * 100)
            : 0;

        $this->progress_percent = $percent;

        foreach ($this->stages as $stage) {
            $stageTotal = $stage->tasks()->count();
            $stageApproved = $stage->tasks()->where('status', 'tasdiqlandi')->count();

            $stage->status = match (true) {
                $stageTotal > 0 && $stageApproved === $stageTotal => 'tugallangan',
                $stageApproved > 0 => 'jarayonda',
                default => $stage->status === 'tugallangan' ? 'jarayonda' : $stage->status,
            };
            $stage->save();
        }

        $this->status = $percent === 100 ? 'yakunlangan' : ($this->status === 'yakunlangan' ? 'jarayonda' : $this->status);

        $this->save();
    }
}
