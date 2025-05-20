<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizQuestionRequest;
use App\Models\ActivitySpecialTasks;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionsOption;
use Illuminate\Http\Request;

class QuizQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return QuizQuestion::where('special_task_id', '=', $id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quiz = ActivitySpecialTasks::where('id', $request["special_task_id"])->first();
        $order_id = QuizQuestion::select('order_id')
            ->where('special_task_id', $request["task_id"])
            ->orderBy('order_id', 'desc')
            ->first();
        if (!$quiz->locked) {
            $question = new QuizQuestion();
            $question->title = "Nowe pytanie";
            $question->special_task_id = $request["special_task_id"];
            $question->type = $request["type"];
            $question->order_id = ($order_id?$order_id:0);
            $question->save();
            return response("Zapisano dane", 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\QuizQuestion $quizQuestions
     * @return \Illuminate\Http\Response
     */
    public function show($quizQuestion)
    {
        return QuizQuestion::where('id', $quizQuestion)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\QuizQuestion $quizQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizQuestion $quizQuestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\QuizQuestion $quizQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizQuestion $question)
    {
        $question = QuizQuestion::where('id', $question["id"])->first();
        $question->title = $request["title"];
        $question->points = $request["points"];
        $question->description = $request["description"];
        $question->type = $request["type"];
        $question->status = $request["status"];
        $question->save();
        QuizQuestionsOption::where('id', $question["id"])->delete();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\QuizQuestion $quizQuestions
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz_id)
    {
        QuizQuestion::where('id', $quiz_id)->delete();
        QuizQuestionsOption::where('question_id', $quiz_id)->delete();
        return response('ok', 204);
    }

    public function destroyQuestionOption($id)
    {
        QuizQuestionsOption::where('id', $id)->delete();
        return response('ok', 204);
    }

    public function storeQuestionOption($question_id)
    {
        $opt = new QuizQuestionsOption();
        $opt->is_correct = 0;
        $opt->name = 'Odpowiedź';
        $opt->question_id = $question_id;
        $opt->save();
        return response('ok', 201);
    }

    public function updateQuestionOptions($id, Request $request)
    {

        $question = QuizQuestion::where('id',$id)->first();
        if ($question->id > 0) {
            $data = $request["_value"];
            QuizQuestionsOption::where('question_id',$question->id)->delete();
            foreach($data as $r) {
                $opt = new QuizQuestionsOption();
                $opt->question_id = $question->id;
                $opt->is_correct = ($r["is_correct"]=="on" || $r["is_correct"] === true?1:0) ?? 0;
                $opt->name = $r["name"];
                $opt->save();
            }
        }
        return response('Zapisano', 201);
    }

    public function getQuestionOptions($question_id) {
        return QuizQuestionsOption::where('question_id', '=', $question_id)->get();
    }

}
