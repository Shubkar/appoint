<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyEvent extends Model
{

    protected $fillable = [
        'id','userId','eventId','calendarName','calendarAccount','customerName','caseId','mobileNumber','dtStart','dtEnd','allDay',
        'chiefComplaint','symptoms','dignosis','feeAmount','balancePayment','paymentMode','remarks','invoiceNumber','eventStatus','isOnline','meetingID','modPasscode','participantsCode','courier','awbNumber','medicine','confirmReceived','courierSent','folloupBooked','appointFlag'
    ];
}
