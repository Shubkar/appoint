<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    protected $fillable = [
        'id','openDate','openingBalance',
    ];
}
