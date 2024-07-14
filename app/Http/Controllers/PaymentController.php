<?php

namespace App\Http\Controllers;
use Shetabit\Multipay\Invoice;
use shetabit\Payment\Fecade\Payment;
use App\Http\Controllers\Controller;
use App\Models\QRcode;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
      public function processPayment(Request $request, Qrcode $qrcode, $date, $appointment){
        $userid=auth()->id();
     
         $appointment=$qrcode->appointments()->where('date_id',$date)->where('appointment_id',$appointment)->first();
        if ($appointment->pivot->status='free'){
            $appointment->pivot->status='reserve';
            $appointment->pivot->save();
          $reservation=Reservation::where('appointment_id',$appointment->id)->first();
        
           
        }

            $payment=Payment::callbackUrl(route('api.payment.callback'))->purchase((new invoice)>ammount(1000),function($driver,$transactionid)
            use($transaction){
                Transaction::create([
                    'amount'=>$amount,
                    'status'=>$pending,
                    'reservation_id'=>$reservation->id
                ]);
                }
            )->pay()->render();
            }
            public function callback(Request $request){
                try{
                    $recipet=Payment::amount(1000)->tranactionid($request->input('authrity'))->veryfy();
                }
            }
             $transaction->update(['status'=>'sucsses']);
             $reservation->update(['user_id'=>$userid]);
            
            if($transaction){
                $transaction->update(['status'=>'failed']);
                $appointment->pivot->status='free';
                $reservation->update(['user_id'=>'null']);
                $appointment->pivot->save();
            }
        }
    }

        
 
}