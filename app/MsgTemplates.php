<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsgTemplates extends Model
{

    protected $fillable = [
       'id', 'msg_type', 'actual_msg', 'msg_time','sub_id',
    ];
}
