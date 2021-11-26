<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;
    protected $table = 'raffles';
    protected $fillable = [
        'prize_id',
        'prize_name',
        'ticket',
        'participant',
        'description',
        'activate',
        'image',
    ];

    protected $with = ['prizes'];
    public function prizes()
    {
        return $this->belongsTo(Prize::class, 'prize_id' , 'id');
    }

    
}
