<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable=['code','user_id','description'];

    public function appointments(){
        return $this->belongsToMany(Appointment::class,'reservation_qrcode')->withPivot(['status']);
    }

    public function  users(){

        return $this->hasMany(User::class);
    }
}
