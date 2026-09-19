<?php

namespace App\Repositories\UserNotification\Models;

use App\Repositories\User\Models\UserSummary;

class UserNotification
{
    public int $id;
    public int $notification_id;
    public ?string $read_at;
    public string $created_at;
    /** @var UserSummary|UserSummary[]|null */
    public $user = null;
    public function __construct(int $id, int $notification_id, ?string $read_at, string $created_at,$user = null)
    {
        $this->id = $id;
        $this->notification_id = $notification_id;
        $this->read_at = $read_at;
        $this->created_at = $created_at;
        $this->user = $user;
    }
    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }

}
