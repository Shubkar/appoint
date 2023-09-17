<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatementGiven extends Model
{
    protected $fillable = [
        'id','myEventsId','medicineName',
    ];
}
