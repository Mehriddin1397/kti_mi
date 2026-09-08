<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationTypeStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_type_id',
        'name',
        'order',
    ];

    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    public function tasks()
    {
        return $this->hasMany(ApplicationTypeTask::class)->orderBy('order');
    }
}
