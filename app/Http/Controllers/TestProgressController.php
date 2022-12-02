<?php

namespace App\Http\Controllers;

use App\Models\TestProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TestProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'test' => 'required',
//            'answers[]' => 'required',
        ], [
            'test.required' => 'Необходимо указать тест',
//            'answers[].required' => 'Необходимо ответить на вопросы',
        ]);

        if ($validator->fails() && isset($data['answers'])) {
            return back()->withErrors($validator->errors());
        }

        $test_progress = new TestProgress();
        $test_progress->user = Auth::user()->id;
        $test_progress->test = $data['test'];
        $test_progress->answers = implode('&', $data['answers']);

        if (!$test_progress->save()) {
            return back()->with('error', 'Не удалось завершить тест');
        }

        return back()->with('success', 'Тест завершён');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestProgress  $testProgress
     * @return \Illuminate\Http\Response
     */
    public function show(TestProgress $testProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestProgress  $testProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(TestProgress $testProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestProgress  $testProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestProgress $testProgress)
    {
        //
    }

    public function test_progress_set_status(Request $request, TestProgress $testProgress)
    {
        $data = $request->all();

        $testProgress->status = $data['status'];

        if (!$testProgress->update()) {
            return back()->with('error', 'Не удалось изменить статус');
        }

        return back()->with('success', 'Статус изменён');
    }

    public function test_progress_set_mark(Request $request, TestProgress $testProgress)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'mark' => 'required',
        ], [
            'mark.required' => 'Необходимо поставить оценку',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $testProgress->mark = $data['mark'];
        $testProgress->comment = $data['comment'];
        $testProgress->status = 'CHECKED';

        if (!$testProgress->update()) {
            return back()->with('error', 'Не удалось изменить статус');
        }

        return back()->with('success', 'Статус изменён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestProgress  $testProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestProgress $tests_progress)
    {
        if (!$tests_progress->delete()) {
            return back()->with('error', 'Не удалось удалить пройденный тест');
        }

        return back()->with('success', 'Пройденный тест удалён');
    }
}
