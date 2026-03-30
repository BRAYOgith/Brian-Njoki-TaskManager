<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'due_date',
        'priority',
        'status'
    ];

    protected $casts = [
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const PRIORITIES = ['low', 'medium', 'high'];
    const STATUSES = ['pending', 'in_progress', 'done'];

    const STATUS_PROGRESSION = [
        'pending' => 'in_progress',  
        'in_progress' => 'done',      
    ];

    public function canTransitionTo(string $newStatus): bool
    {
        return isset(self::STATUS_PROGRESSION[$this->status]) 
            && self::STATUS_PROGRESSION[$this->status] === $newStatus;
    }

    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        if ($status && in_array($status, self::STATUSES)) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
