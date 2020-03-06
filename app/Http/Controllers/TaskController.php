<?php

namespace App\Http\Controllers;

use App\Model\Annotator;
use App\Model\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        return view('task.index');
    }

    /**
     * Get all task
     *
     * @param App\Model\Task $task
     * @return json
     */
    public function allDatatables(Task $task)
    {
        return $task->allDatatables();
    }

    /**
     * Get all task are not booked yet with datatables format
     *
     * @param App\Model\Task $task
     * @return json
     */
    public function notBookedDatatables(Task $task)
    {
        return $task->notBookedDatatables();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Task  $task
     * @return route
     */
    public function store(Request $request, Task $task)
    {
        // validation file format (zip)
        $this->validate($request, [
            'dataset' => 'required|file|mimes:zip',
        ]);

        $task->store($request);

        toast('Your data as been submited!','success'); // Show pop-up notification

        return redirect()->route('task.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Task $task
     * @return view
     */
    public function edit(Task $task)
    {
        $annotators = Annotator::all();

        return view('task.edit', compact('task', 'annotators'));
    }

    /**
     * Update the specified resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Task $task
     * @return route
     */
    public function update(Request $request, Task $task)
    {
        $task->updateCustom($request);

        toast('Your data as been updated!','success'); // Show pop-up notification

        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from database.
     *
     * @param  \App\Model\Task $task
     * @return session toast()
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }

    /**
     * Download dataset
     *
     * @param int $id
     * @return void
     */
    public function download($id)
    {
        $task = Task::find($id);

        return $task->download();
    }

    /**
     * Revoke Booking
     *
     * @param int $id
     * @return void
     */
    public function revoke($id)
    {
        $task = Task::find($id);
        return $task->revoke();
    }

    /**
     * Display a listing of the not booked Task.
     *
     * @return view
     */
    public function notBooked()
    {
        return view('task.not_booked');
    }

    /**
     * Booking task
     *
     * @return route
     */
    public function book($id)
    {
        $task = Task::find($id);

        $task->book(); // Book process

        toast('Task has been booked','success'); // Show pop-up notification

        return redirect()->route('annotator.task.not.booked');
    }
}
