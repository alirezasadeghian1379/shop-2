<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';
    protected $guarded = [];
    protected $appends = ['jalali_created_at'];

    public function getJalaliCreatedAtAttribute()
    {
        return isset($this->created_a) ? verta($this->created_at)->format('%d %B Y ( H:i )'):null;
    }
}
