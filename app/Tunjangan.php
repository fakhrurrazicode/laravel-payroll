<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tunjangan extends Model
{
    protected $table = 'tunjangan';
    protected $fillable = [
        'tunjanganable_type',
        'tunjanganable_id',
        'deskripsi',
        'nilai',
    ];

    public function tunjanganable()
    {
        return $this->morphTo();
    }
}
