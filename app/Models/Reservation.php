<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable=['user_id','qrcode_id','appointmant_id','status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function qrcode(){
        return $this->belongsTo(Qrcode::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }




}
