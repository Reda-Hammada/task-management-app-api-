<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'phase',
        'board_id'
    ];



    public function Board()
    { 
        return $this->belongsTo(
                Board::class
        );
    }


    public function Tasks()
    {
        return $this->hasMany('App\Tasks');
    }
}




