<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Relations\BelongsToThrough;

class Task extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'title',
        'description',
        'assignee_id',
        'due_at',
        'completed_at',
        'section_id',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function assigner(): BelongsToThrough
    {
        return $this->belongsToThrough(User::class, Membership::class, '');
    }

    public function assignee(): BelongsToThrough
    {
        return $this->belongsToThrough(User::class, Membership::class, 'assignee_id');
    }
}
