<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
        'name', 'type','user_id','slug','description','publish_at',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }
    public function files(){
        return $this->morphToMany(File::class,'fileable');
    }
     
}
