<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['venue_id', 'title', 'event_date', 'description', 'details', 'starts_at'];

    protected $casts = [
        'event_date' => 'date',
        'details' => 'array',
        'starts_at' => 'datetime',
    ];

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

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now());
    }

    public function scopeEarliestFirst(Builder $query): Builder
    {
        return $query->orderBy('starts_at');
    }

    public function scopeDressCode(Builder $query, string $code): Builder
    {
        return $query->where('details->dress_code', $code);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->whereFullText('description', $term);
    }

    public function scopeForList(Builder $query): Builder
    {
        return $query->with('venue')->withCount('participants');
    }
}