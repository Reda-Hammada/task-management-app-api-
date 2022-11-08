<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'board_name',
        'user_id',
    ];


    public function User()
    {

        return $this->belongsTo(User::class);
    }


    public function Phase()
    {
        return $this->hasMany(Phase::class);
    }


    public static function boot()
    {
        parent::boot();


        static::deleting(function(Board $board){

                $board->Phase()->delete();
        });
    }
 
}
