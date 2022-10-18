<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'category', 'platform', 'progress', 'status', 'proposal','team_id', 'client_id'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
