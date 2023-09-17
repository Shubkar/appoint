<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageQue extends Model
{
     protected $fillable = [
     'appointmentId', 'templateId', 'message','sentOn',
     ];
}
