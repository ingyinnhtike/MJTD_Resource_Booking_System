<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlotOne extends Model
{
    protected $fillable = [
        'time_slot',
        'schedule_id'
    ];
}
