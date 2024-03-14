<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class status extends Model
{
    use HasFactory;
    protected $table = 'status';


    protected $fillable = [
        'status_name',
    ];

    public function task(): HasMany
    {
        return $this->hasMany(task::class);
    }

}
