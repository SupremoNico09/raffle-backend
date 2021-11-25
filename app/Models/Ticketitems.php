<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketitems extends Model
{
    use HasFactory;
    protected $table = 'ticketitems';
    protected $fillable = [
        'ticket_id',
        'raffle_id',
        'qty',
        'price',
    ];

    protected $with = ['tickets'];
    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id' , 'id');
    }


}
