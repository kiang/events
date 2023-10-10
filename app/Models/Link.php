<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'note'];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
