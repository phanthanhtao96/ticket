<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'rating',
        'rating1',
        'rating2',
        'rating3',
        'rating4',
        'response_rating',
        'message'
    ];
}
