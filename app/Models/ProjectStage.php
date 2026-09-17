<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'order',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->orderBy('order');
    }

    /**
     * A stage is unlocked when every earlier stage of the same project
     * has already been fully completed (all of its tasks approved).
     */
    public function isUnlocked(): bool
    {
        return ! ProjectStage::where('project_id', $this->project_id)
            ->where('order', '<', $this->order)
            ->where('status', '!=', 'tugallangan')
            ->exists();
    }
}
