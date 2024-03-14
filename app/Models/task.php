<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class task extends Model
{
    use HasFactory;

    protected $table = 'tasks';


    protected $fillable = [
        'status_id',
        'project_id',
        'task_name',
        'task_dealine',
        'task_tag'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(status::class);
    }

    public function permission(): HasMany
    {
        return $this->hasMany(permission::class);
    }

    public function worker(): HasMany
    {
        return $this->hasMany(worker::class);
    }
}
