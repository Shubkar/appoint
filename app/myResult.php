<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myResult extends Model
{
    protected $fillable = [
        'isException','result',
    ];

    public function myResult($isException,$result)
    {
        $this->$isException=$isException;
        $this->$result=$result;
    }
}
