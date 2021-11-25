<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'street',
        'house',
        'city',
        'zipcode',
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
