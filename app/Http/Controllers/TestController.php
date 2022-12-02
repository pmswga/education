<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Test;
use App\Models\TestProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tests.index', [
            'courses' => Course::all(),
            'tests' => Test::all()->sortBy('created_at'),
            'tests_progress' => TestProgress::all()
        ]);
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
            'caption' => 'required',
            'course' => 'required',
            'questions' => 'required',
        ], [
            'caption.required' => 'Необходимо дать название тесту',
            'course.required' => 'Необходимо выбрать курс',
            'questions.required' => 'Необходимо перечислить вопросы',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $test = new Test();
        $test->course = $data['course'];
        $test->questions = str_replace("\n", "&", $data['questions']);

        if (!$test->save()) {
            return back()->with('error', 'Не удалось добавить тест');
        }

        return back()->with('success', 'Тест добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    public function passing_test(Test $test)
    {
        return view('tests.passing_test', [
            'test' => $test
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
