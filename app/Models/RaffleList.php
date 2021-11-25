<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleList extends Model
{
    use HasFactory;
    protected $table = 'rafflelists';
    protected $fillable = [
        'user_id',
        'raffle_id',
        'ticket_qty',

    ];

    protected $with = ['raffle'];
    public function raffle()
    {
        return $this->belongsTo(Raffle::class, 'raffle_id', 'id');
    }
}
