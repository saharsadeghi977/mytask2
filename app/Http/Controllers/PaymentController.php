<?php

namespace App\Http\Controllers;
use Shetabit\Multipay\Invoice;
use shetabit\Payment\Fecade\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
      public function processPayment(Request $request, Qrcode $qrcode, $date, ,$appointment){
         $appointmentid=$request->input('$appointment');
         $appointment=$qrcode->appointments()->where('date_id',$date)->where('appointment_id',$appointmentid)->first();
        if ($appointment->pivot->status='free'){

            $appointment->pivot->status='reserved';
            $appointment->pivot->save();
            $payment=Payment::callbackUrl(route('api.payment.callback'))->purchase((new invoice)>ammount(1000),function($driver,$transactionid)
            use($transaction){
                Transaction::create([
                    'amount'=>$amount,
                    'status'=>$pending,
                    'reservation_id'=>$appintmentid
                ])
            }
            )->pay()->render();
            }
            public function callback(Request $request){
                try{
                    $recipet=Payment::amount(1000)->tranactionid($request->input('authrity'))->veryfy();
                }
            }
            $transaction->update(['status'=>'sucsses']);
            if($transaction){
                $transaction->update(['status'=>'failed']);
                $appointment->pivot->status='free';
                $appointment->pivot->save();
            }
        }
    }
}
