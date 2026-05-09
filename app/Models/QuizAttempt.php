<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'duration_seconds',
        'answers_json',
    ];

    protected function casts(): array
    {
        return [
            'score'            => 'integer',
            'duration_seconds' => 'integer',
            'answers_json'     => 'array',
            'attempted_at'     => 'datetime',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
