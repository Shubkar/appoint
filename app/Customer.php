<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'userId', 'name', 'caseId','mobile','email','status','gender' , 'age' , 'occupation' , 'refferedBy' ,
        'infoSharing' , 'newsLetter' , 'address' , 'ethnicity','idNumber','remark1','remark2','dateofConsultation','photo','cpatured_photo'
    ];
}
