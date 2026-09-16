<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Question\QuestionStoreRequest;
use App\Http\Requests\Web\Question\QuestionUpdateRequest;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionService $question,
    ){
        $this->middleware('checkPermission:question');
    }

    public function index()
    {
        try {
            $questions = $this->question->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.questions.index',compact('questions'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }

    public function create()
    {
        try {
            return view('admin.questions.create');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }

    public function store(QuestionStoreRequest $request)
    {
        try {
            $this->question->create($request->all());
            alert()->success('تایید','سوال جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.questions.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }

    public function edit($id)
    {
        try {
            $question = $this->question->findById($id);
            return view('admin.questions.create',compact('question'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }

    public function update(QuestionUpdateRequest $request, $id)
    {
        try {
            $this->question->update($id,$request->all());
            alert()->success('تایید','سوال مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.questions.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }

    public function destroy($id)
    {
        try {
            $this->question->destroy($id);
            alert()->success('تایید','سوال مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.questions.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.questions.index');
        }
    }
}

