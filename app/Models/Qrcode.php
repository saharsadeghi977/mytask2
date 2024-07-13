<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable=['code','user_id','description'];

    public function  users(){

        return $this->belongsTo(User::class);
    }

    public function appointments(){
        return $this->belongsToMany(Appointment::class,'reservations')->withPivot(['status']);
    }
}
