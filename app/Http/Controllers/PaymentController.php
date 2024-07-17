<?php
namespace App\Http\Controllers;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use App\Http\Controllers\Controller;
use App\Models\QRcode;
use App\Models\Transaction;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
      
    public function processPayment(Request $request, Qrcode $qrcode, $date, $appointment)
    {
        $userid = 1;
     
        $appointment = $qrcode->appointments()->where('date_id', $date)->where('appointment_id', $appointment)->first();
        if ($appointment->pivot->status == 'free') {
             $appointment->pivot->status = 'reserve';
            $appointment->pivot->save();
            $reservation = Reservation::where('appointment_id', $appointment->id)->first();
            $payment = Payment::callbackUrl('/callback')->purchase(
                (new Invoice)->amount(1000),
                function ($driver, $transactionId) use ($reservation) {
                    $transaction = Transaction::create([
                        'amount' => 1000,
                        'status' => 'pending',
                        'reservation_id' => $reservation->id,
                         'transaction_id'=> $transactionId
                    ]);
                }
            )->pay();

            return $payment;
        } else {
            return response()->json(['message' => 'Appointment is already reserved'], 400);
        }
    }

    public function callback(Request $request )

    {
        $userid=3;
        $receipt = Payment::amount(1000)->transactionId($request->input('transactionId'))->verify();
            $transaction = Transaction::where('transaction_id', $request->input('transactionId'))->first();
            $transaction->update(['status' => 'success']);
            $reservation=$transaction->reservation;
            dd($reservation);
            $reservation->update(['user_id' =>$userid]);
        try {
    
        } catch (\Exception $e) {
                $transaction->update(['status' => 'failed']);
                $appointment->pivot->status = 'free';
                $appointment->pivot->save();
                

            return response()->json(['message' => 'Payment failed'], 500);
        }

        return response()->json(['message' => 'Payment successful'], 200);
    } }       
 