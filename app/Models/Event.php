<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['venue_id', 'title', 'event_date'];

    protected $casts = ['event_date' => 'date'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class)->withPivot('status')->withTimestamps();
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
