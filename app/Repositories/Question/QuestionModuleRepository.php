<?php

namespace App\Repositories\Question;

use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Question\Models\Question;
use Illuminate\Support\Collection;
use App\Models\Question as QuestionModel;
class QuestionModuleRepository implements IQuestionRepository
{

    public function all(): Collection
    {
        $questions = QuestionModel::latest()->get()->map(fn($question) => new Question(
            $question->id,
            $question->question,
            $question->answer,
            $question->active,
            $question->created_at,
        ));
        return $questions;
    }

    public function getActiveAll(): Collection
    {
        $questions = QuestionModel::where('active',1)->latest()->get()->map(fn($question) => new Question(
            $question->id,
            $question->question,
            $question->answer,
            $question->active,
            $question->created_at,
        ));
        return $questions;
    }

    public function paginate(int $perPage): PaginatorAdapter
    {
        $questions = QuestionModel::latest()->paginate($perPage);
        $questions->setCollection(
            $questions->getCollection()->map(fn($question) => new Question(
                $question->id,
                $question->question,
                $question->answer,
                $question->active,
                $question->created_at,
            ))
        );
        return new EloquentPaginatorAdapter($questions);
    }

    public function findById(int $id): Question
    {
        $question = QuestionModel::where('id', $id)->first();
        if (!$question) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Question(
            $question->id,
            $question->question,
            $question->answer,
            $question->active,
            $question->created_at,
        );
    }

    public function create(array $data): bool
    {
        QuestionModel::create([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'active' => isset($data['active']) && $data['active'] == 'on'?1:0,
        ]);
        return true;
    }

    public function update(int $id, array $data): bool
    {
        $question = QuestionModel::where('id', $id)->first();
        if (!$question) throw new Exception('اطلاعاتی یافت نشد!',404);
        $question->update([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'active' => isset($data['active']) && $data['active'] == 'on'?1:0,
        ]);
        return true;
    }

    public function destroy(int $id): bool
    {
        $question = QuestionModel::where('id', $id)->first();
        if (!$question) throw new Exception('اطلاعاتی یافت نشد!',404);
        $question->delete();
        return true;
    }
}
