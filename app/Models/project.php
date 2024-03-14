<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class project extends Model
{
    use HasFactory;

    
    protected $table = 'projects';


    protected $fillable = [
        'user_infor_id',
        'project_name'
    ];

    public function user_infor(): BelongsTo
    {
        return $this->belongsTo(user_infor::class);
    }
}
