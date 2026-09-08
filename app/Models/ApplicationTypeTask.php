<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationTypeTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_type_stage_id',
        'name',
        'description',
        'default_responsible_user_id',
        'order',
    ];

    public function stage()
    {
        return $this->belongsTo(ApplicationTypeStage::class, 'application_type_stage_id');
    }

    public function defaultResponsibleUser()
    {
        return $this->belongsTo(User::class, 'default_responsible_user_id');
    }
}
