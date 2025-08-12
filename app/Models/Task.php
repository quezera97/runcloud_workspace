<?php

namespace App\Models;

use App\Traits\TrackActionWithoutSoftDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, TrackActionWithoutSoftDelete;

    protected $fillable = [
        'workspace_id',
        'title',
        'deadline',
        'completed',
        'completed_at',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
