<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\TasksModel;
use Carbon;
class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('tasks');

    }
    public function showAll()
    {
        // Get articles
        $tasks_lists = TasksModel::orderBy('id', 'desc')
            ->get();
        return $tasks_lists;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tasks_lists = TasksModel::orderBy('id', 'desc')
            ->get();
        return $tasks_lists;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = $request->isMethod('put') ? TasksModel::findOrFail($request->id) : new TasksModel;
        $tasks->title = $request->input('title');
        $tasks->body = $request->input('body');
        $tasks->status = $request->input('status');
        $tasks->destination = $request->input('destination');
        if($tasks->save()) {
            //return true;
            return response()->json($tasks);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budget = TasksModel::findOrFail($id);
        if($budget->delete()) {
            return response()->json($budget);
        }
    }
}
