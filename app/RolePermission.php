<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'role_has_permissions';
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::createFromTimestamp($date->getTimestamp())->toDateTimeString();
    }
}
