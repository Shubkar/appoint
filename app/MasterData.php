<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    protected $fillable = [
    'id', 'dataType', 'masterValues',
    ];
}
