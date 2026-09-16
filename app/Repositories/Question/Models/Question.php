<?php
namespace App\Repositories\Question\Models;
class Question
{
    public int $id;
    public string $question;
    public string $answer;
    public bool $active;
    public string $created_at;

    public function __construct(int $id, string $question, string $answer, bool $active, string $created_at)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->active = $active;
        $this->created_at = $created_at;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
}
