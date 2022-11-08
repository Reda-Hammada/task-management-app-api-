<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;


    public function Phase()
    {

        return $this->belongsTo(Phase::class);
    }

    public function Subtasks()
    {
        return $this->hasMany(Subtasks::class);

    }
}
