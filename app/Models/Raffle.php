<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;
    protected $table = 'raffles';
    protected $fillable = [
        'raffle_prize',
        'ticket',
        'participant',
        'description',
        'image',
    ];
}
