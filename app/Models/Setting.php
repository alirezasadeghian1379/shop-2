<?php

namespace App\Models;

use App\Enums\Gallery\StorageTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = [];


    public function logo()
    {
        return $this->hasOne(Storage::class,'item_id')->where('type' ,StorageTypeEnum::LOGO)->latest();
    }
    public function icon()
    {
        return $this->hasOne(Storage::class,'item_id')->where('type' ,StorageTypeEnum::ICON)->latest();
    }
    public function watermark()
    {
        return $this->hasOne(Storage::class,'item_id')->where('type' ,StorageTypeEnum::WATERMARK)->latest();
    }
}
