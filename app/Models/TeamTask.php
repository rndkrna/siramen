<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamTask extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'team_id',
        'team_member_id',
        'task_name',
        'status',
        'priority',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function member()
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }
}
