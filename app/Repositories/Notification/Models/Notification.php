<?php

namespace App\Repositories\Notification\Models;

use App\Enums\Notification\NotificationTypeEnum;
use App\Repositories\User\Models\UserSummary;

class Notification
{
    public int $id;
    public string $title;
    public string $message;
    public string $type;
    public ?string $url;
    public bool $is_global;
    public string $created_at;
    /** @var UserSummary[]|null */
    public $users = null;
    public function __construct(int $id, string $title, string $message, string $type, ?string $url, bool $is_global, string $created_at,$users = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
        $this->is_global = $is_global;
        $this->created_at = $created_at;
        $this->users = $users;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }

    public function getTypePersian():string
    {
        return NotificationTypeEnum::getTypesDescription()[$this->type];
    }

    public function getTypeColor():string
    {
        return NotificationTypeEnum::getTypesColor()[$this->type];
    }
}
