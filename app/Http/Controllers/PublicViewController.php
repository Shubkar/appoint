<?php

namespace App\Http\Controllers;

use App\Letters;
use App\MyEvent;
use App\TreatementGiven;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicViewController extends Controller
{
    public function viewInvoice(Request $request)
    {
        $printData='';
        $appointment=MyEvent::find(\base64_decode($request->get('appointmentId')));
        if($appointment!=null)
        {
            $doc=User::find($appointment->userId);

            $letterData=Letters::where('appointmentId',$request->get('appointmentId'))->where('letterType','Receipt')->first();
            if($appointment->invoiceNumber==null)
            {
                $printData="<div class='row'>
                    <div class='col-sm-12'> <img src='". ' http://'.request()->getHttpHost(). $doc->headerImage ."'
                        style='width: 100%;' />

                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <div class='alert alert-danger'>We have received no/partial amount. Kindly pay full amount to generate invoice.</div>

                        <p>&nbsp;</p>

                        <p><span style='font-size:11pt'><span
                                    style='font-family:Calibri,sans-serif'>___________________</span></span></p>

                        <p><span style='font-size:11pt'><span style='font-family:Calibri,sans-serif'>Authorized
                                    Chop</span></span></p>
                        <img src='". ' http://'.request()->getHttpHost(). $doc->footerImage ."'
                        class='divFooter' />
                    </div>";
            }
            else if($letterData==null)
            {
                $printData="<div class='row'>
                    <div class='col-sm-12'> <img
                            src='". 'http://'.request()->getHttpHost(). $doc->headerImage ."'
                            style='width: 100%;' />
                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <table border='1' cellpadding='5' cellspacing='0' style='width:100%'>
                            <tbody>
                                <tr>
                                    <td><strong>Patient Name:</strong> ". $appointment->customerName ."</td>
                                    <td><strong>Date:</strong>
                                        ". Carbon::createFromFormat('Y-m-d H:i:s', $appointment->dtStart)->format('d/m/Y') ."
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Case #</strong>". $appointment->caseId ."</td>
                                    <td><strong>Receipt no:</strong>". $appointment->invoiceNumber ."</td>
                                </tr>
                            </tbody>
                        </table>

                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <table border='1' cellpadding='5' cellspacing='0' style='width:100%'>
                            <tbody>
                                <tr>
                                    <th style='background-color:#eeeeee'>SNo</th>
                                    <th style='background-color:#eeeeee'>Description</th>
                                    <th style='background-color:#eeeeee'>Amount</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Consultation and remedy Charges for ". $appointment->chiefComplaint ."</td>
                                    <td>". $doc->currencyCode ." ". $appointment->feeAmount ."</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><strong>Total Amount</strong></td>
                                    <td><strong>". $doc->currencyCode ." ". $appointment->feeAmount ."</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>

                        <p><span style='font-size:11pt'><span
                                    style='font-family:Calibri,sans-serif'>___________________</span></span></p>

                        <p><span style='font-size:11pt'><span style='font-family:Calibri,sans-serif'>Authorized
                                    Chop</span></span></p>
                        <img src='". 'http://'.request()->getHttpHost(). $doc->footerImage ."'
                            class='divFooter' />
                    </div>";
            }
            else
            {
                $printData=$letterData->letterData;
            }
        }
        return view('Appointments.invoiceView',compact('printData'));
    }
}
