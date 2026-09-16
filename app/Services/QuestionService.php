<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Question\Models\Question;
use Illuminate\Support\Collection;

class QuestionService
{
    public function __construct(
        protected IQuestionRepository $question
    ){}

    public function all(): Collection
    {
        return $this->question->all();
    }

    public function getActiveAll(): Collection
    {
        return $this->question->getActiveAll();
    }

    public function paginate(int $perPage): PaginatorAdapter
    {
        return $this->question->paginate($perPage);
    }

    public function findById(int $id): Question
    {
        return $this->question->findById($id);
    }

    public function create(array $data): bool
    {
        return $this->question->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->question->update($id,$data);
    }

    public function destroy(int $id): bool
    {
        return $this->question->destroy($id);
    }
}
