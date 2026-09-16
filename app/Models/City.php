<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($city) {
            if (empty($city->slug)) {
                $city->slug = generateUniqueSlug(self::class,$city->name,'slug');
            }
        });
        static::updating(function ($city) {
            $city->slug = generateUniqueSlug(self::class,$city->name,'slug',$city->id);
        });
    }
    public function province()
    {
        return $this->belongsTo(Province::class,'province_id');
    }
}
