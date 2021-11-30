<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'raffle_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'payment_id',
        'payment_mode',
        'tracking_no',
        'terms',
    ];

    public function ticketitems()
    {
        return $this->hasMany(Ticketitems::class, 'ticket_id', 'id');
    }

}
