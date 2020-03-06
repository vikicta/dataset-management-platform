<?php

namespace App\Http\Controllers;

use App\Model\Annotator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AnnotatorController extends Controller
{
    /**
     * Display a annotator view
     *
     * @return view
     */
    public function index()
    {
        return view('annotator.index');
    }

    /**
     * Get all annotator with datatables format
     *
     * @param App\Model\Annotator $annotator
     * @return json
     */
    public function allDatatables(Annotator $annotator)
    {
        return $annotator->allDatatables();
    }

    /**
     * Show the form for creating a new annotator.
     *
     * @return view
     */
    public function create()
    {
        return view('annotator.create');
    }

    /**
     * Store a newly created annotator in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Model\Annotator $annotator
     * @return view
     */
    public function store(Request $request, Annotator $annotator)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:annotators,username',
            'password' => 'required'
        ]);

        $annotator->create($request->all());

        toast('Your data as been submited!','success'); // show pop-up notification

        return redirect()->route('annotator.index');
    }

    /**
     * Show the form for editing the specified annotator.
     *
     * @param  App\Model\Annotator $annotator
     * @return view
     */
    public function edit(Annotator $annotator)
    {
        return view('annotator.edit', compact('annotator'));
    }

    /**
     * Update the specified annotator in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Model\Annotator $annotator
     * @return view
     */
    public function update(Request $request, Annotator $annotator)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:annotators,username,' . $annotator->id,
        ]);

        $annotator->updateCustom($request);

        toast('Your data as been updated!','success'); // show pop-up notification

        return redirect()->route('annotator.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Annotator
     * @return session toast()
     */
    public function destroy(Annotator $annotator)
    {
        $annotator->delete();
    }

    /**
     * Display the specified annotator tasks view
     *
     * @return view
     */
    public function myTasks()
    {
        return view('annotator.my_tasks');
    }

    /**
     * Get all specified Annotator's tasks with datatables format
     *
     * @return json
     */
    public function myTasksDatatables()
    {
        $myTasks = auth()
                ->guard('annotator')
                ->user()
                ->myTasksDatatables();

        return $myTasks;
    }
}
