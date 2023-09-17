<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientReports extends Model
{
    protected $fillable = [
        'id','appointmentId','caseId','reportUrl'
    ];
}
