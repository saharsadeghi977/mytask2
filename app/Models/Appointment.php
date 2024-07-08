<?php

namespace App\Models;
use App\Models\User;
use App\Models\Qrcode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable=['date_id','type','time'];

   
    public function qrCodes()
    {
        return $this->belongsToMany(QrCode::class,'reservation_qrcode')->withPivot(['status']);
    }

    public function date()
    {
        return $this->blongsTO(Date::class);
    }

    

}
