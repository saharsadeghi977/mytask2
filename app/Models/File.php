<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'title',
        'type',
        'storages',
        'path',
        'hash',
        'entry',
    ];

    use HasFactory;

    protected $casts=[
      'entry'=>'array',
        'storages'=>'array'
    ];


    public function fileables()
    {
        return $this->morphToMany(Fileable::class, 'fileable');
    }
}
