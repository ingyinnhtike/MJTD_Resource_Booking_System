<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlotZero extends Model
{
    protected $fillable = [
        'time_slot_0',
        'time_slot_1',
        'time_slot_2',
        'time_slot_3',
        'time_slot_4',
        'time_slot_5',
        'time_slot_6',
        'schedule_id'
    ];
}
