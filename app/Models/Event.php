<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['time_gather', 'time_end', 'place_id', 'team_id', 'name', 'note'];

    public function place() {
        return $this->belongsTo(Place::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }   
}
