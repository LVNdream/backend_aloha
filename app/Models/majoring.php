<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class majoring extends Model
{
    use HasFactory;

    protected $table = 'majorings';


    protected $fillable = [
        'majoring_name',
    ];

    public function user_infor(): HasMany
    {
        return $this->hasMany(user_infor::class,"majoring_id");
    }
}
