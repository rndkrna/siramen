<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Summary extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'content_md',
        'key_points',
        'possible_questions',
        'language',
        'tokens_used',
    ];

    protected function casts(): array
    {
        return [
            'key_points'         => 'array',
            'possible_questions' => 'array',
            'tokens_used'        => 'integer',
            'created_at'         => 'datetime',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
