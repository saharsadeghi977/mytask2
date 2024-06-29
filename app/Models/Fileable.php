<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{
    use HasFactory;
    protected $table='fileables';

    protected $fillable=[
        'file_id',
        'fileable_id',
        'fileable_type',

    ];


}
