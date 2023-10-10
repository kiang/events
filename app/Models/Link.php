<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['title', 'url', 'note'];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
