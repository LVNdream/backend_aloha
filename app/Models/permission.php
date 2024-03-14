<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    protected $fillable = [
        'user_infor_id',
        'task_id',
        'read',
        'write',
    ];

   

    public function user_infor(): BelongsTo
    {
        return $this->belongsTo(user_infor::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(task::class);
    }
}
