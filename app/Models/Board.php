<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Board;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'board_name',
        'user_id',
    ];

 
}
