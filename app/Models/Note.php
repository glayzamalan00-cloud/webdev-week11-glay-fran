<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['noteable_type', 'noteable_id', 'body'];

    public function noteable()
    {
        return $this->morphTo();
    }

    public function getSubjectNameAttribute()
    {
        return $this->noteable->name ?? $this->noteable->title;
    }

    public function getSubjectTypeAttribute()
    {
        return class_basename($this->noteable_type);
    }
}
