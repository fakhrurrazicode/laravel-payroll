<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = [
        'nama',
        'gaji_pokok',
    ];

    public function tunjangan()
    {
        return $this->morphMany(Tunjangan::class, 'tunjanganable');
    }
}
