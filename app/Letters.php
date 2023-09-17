<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letters extends Model
{
    protected $fillable = [
    'appointmentId', 'letterType', 'letterData',
    ];
}
