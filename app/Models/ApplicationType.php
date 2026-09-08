<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function stages()
    {
        return $this->hasMany(ApplicationTypeStage::class)->orderBy('order');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
