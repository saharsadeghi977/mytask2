<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\QRcode;
use App\Models\Date;
use App\Http\Requests\ValidateStatusRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( $qrcode , $date)
    {  
        $appointments=Appointment::query()->whereHas('qrcodes',function($query)use ($qrcode){
            $query->where('qrcode_id',$qrcode);
        })->where('date_id',$date)->get();
        
       $freeAppointments=$appointments->filter(function($appointment){
        return $appointment->qrcodes->first()->pivot->status=='free';
       })->pluck('time')->implode(',');

       $busyAppointments=$appointments->filter(function($appointment){
        $status=$appointment->qrcodes->first()->pivot->status;
        return $status == 'reserved'||$status == 'inactive';
       })->pluck('time')->implode(',');
       
          return response()->json([
            'data'=>[
                'free_appointments'=>$freeAppointments,
                'busy_appointments'=>$busyAppointments
            ]
          ]);

            }
    
        
    public function changestatus( Request $request, Qrcode $qrcode, $date, $appointment )
    {
        $user=Auth::user();
       $qrcode->user_id==$user;
        //  $validated = $request->validated();
        $request->validate([
        'status'=>'required|string|in:free,inactive'
    ]);
     
    $appointment=$qrcode->appointments()->where('date_id',$date)->where('appointment_id',$appointment)->first();
     $appointment->pivot->status=$request->input('status');
      $appointment->pivot->save();
     
       return response()->json(['message'=>'status update successfully']);
     
     
    }

    /**
     * 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
