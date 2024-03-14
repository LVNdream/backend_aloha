<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class user_infor extends Model
{
    use HasFactory;
    protected $table = 'user_infor';


    protected $fillable = [
        'fullname',
        'birthday',
        'gender',
        'phone',
        "avata",
        'majoring_id'


    ];

    public function majoring(): BelongsTo
    {
        return $this->belongsTo(user_infor::class,'majoring_id');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): HasMany
    {
        return $this->hasMany(project::class);
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
