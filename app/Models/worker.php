<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class worker extends Model
{
    use HasFactory;

    protected $table = 'workers';


    protected $fillable = [
        'task_id',
        'user_infor_id',
    ];

    public function user_infor(): BelongsTo
    {
        return $this->belongsTo(user_infor::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(task::class,"task_id");
    }
}
