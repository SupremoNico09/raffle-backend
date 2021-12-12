<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winners extends Model
{
    use HasFactory;
    protected $table = 'winners';
    protected $fillable = [
        'raffle_id',
        'tracking_no',
    ];


    protected $with = ['tickets'];
    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'tracking_no' , 'tracking_no');
    }

}
