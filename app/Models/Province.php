<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($province) {
            if (empty($province->slug)) {
                $province->slug = generateUniqueSlug(self::class,$province->name,'slug');
            }
        });
        static::updating(function ($province) {
            $province->slug = generateUniqueSlug(self::class,$province->name,'slug',$province->id);
        });
    }

    public function cities()
    {
        return $this->hasMany(City::class,'province_id');
    }
}
