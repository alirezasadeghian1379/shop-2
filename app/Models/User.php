<?php

namespace App\Models;

use App\Enums\Gallery\StorageTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'users';
    protected $guarded = [];
    protected $appends = ['jalali_created_at','jalali_updated_at','full_name'];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getFullNameAttribute(): ?string
    {
        return (isset($this->first_name) ? $this->first_name : '') . ' ' . (isset($this->last_name) ? $this->last_name : '');
    }
    public function getJalaliCreatedAtAttribute(): ?string
    {
        return isset($this->created_at) ? verta($this->created_at)->format('%d %B Y ( H:i )'):null;
    }
    public function getJalaliUpdatedAtAttribute(): ?string
    {
        return isset($this->updated_at) ? verta($this->updated_at)->format('%d %B Y ( H:i )'):null;
    }
    public function avatar()
    {
        return $this->hasOne(Storage::class,'item_id')->where('type' ,StorageTypeEnum::AVATAR)->latest();
    }
}
