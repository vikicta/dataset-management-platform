<?php

namespace App\Model;

use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes; // Use soft delete when task is delete

    protected $fillable = [
        'name', 'annotator_id', 'dataset_name', 'dataset_path'
    ];

    protected $dates = ['deleted_at'];

    /**
     * relation to Annotator model
     *
     * @return eloquent
     */
    public function annotator()
    {
        return $this->hasOne(Annotator::class, 'id', 'annotator_id');
    }

    /**
     * Generate task name
     *
     * @param file $value
     * @return string
     */
    public function generateName()
    {
        $id = 1;

        $lastID = $this->latest()
            ->orderBy('id', 'desc')
            ->pluck('id')
            ->first();

        if (!is_null($lastID)) {
            $id = $lastID + 1;
        }

        return 'Task ' . $id;
    }

    /**
     * Store file to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function storeToStorage($request)
    {
        $dataset = $request->file('dataset');

        $dataset_name = $dataset->getClientOriginalName();

        $dataset_path = Storage::put('datasets', $dataset); // store to storage/app/datasets folder

        return [
            'dataset_name' => $dataset_name,
            'dataset_path' => $dataset_path,
        ];
    }

    /**
     * store task
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store($request)
    {
        $file = $this->storeToStorage($request);

        $this->dataset_name = $file['dataset_name'];
        $this->dataset_path = $file['dataset_path'];

        $this->save();
    }

    /**
     * Update Task
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateCustom($request)
    {
        // check file is exist
        if ($request->hasFile('dataset')) {

            $file = $this->storeToStorage($request); // store file upload to storage

            Storage::delete($this->dataset_path); // Remove dataset

            // add name and path dataset to $request
            $request->merge([
                'dataset_name' => $file['dataset_name'],
                'dataset_path' => $file['dataset_path']
            ]);
        }

        $this->update($request->all());
    }

    /**
     * Download Dataset
     *
     * @return file
     */
    public function download()
    {
        $annotator = Auth::guard('annotator');

        $check = true;

        // prevents annotator from downloading data that is not booked
        if ($annotator->check()) {

            $annotatorID = $annotator->user()->id;

            if ($this->annotator_id != $annotatorID) {
                $check = false;
            }

        }

        if ($check) {
            return Storage::download($this->dataset_path, $this->dataset_name); // get dataset file and download with original name
        }

        toast("Can't download this dataset", "warning");

        return redirect()->back();

    }

    /**
     * Revoke Booking Task
     *
     * @return void
     */
    public function revoke()
    {
        $this->annotator_id = null;

        $this->update();
    }

    /**
     * Get all task and adding edit and delete button with datatables format
     *
     * @return json
     */
    public function allDatatables()
    {
        $tasks = $this::with('annotator')->orderBy('created_at', 'desc');

        $datatables = DataTables::eloquent($tasks)
                        ->addColumn('action', function($tasks){

                            $revokeButton = '';

                            if (!is_null($tasks->annotator_id)) {
                                $revokeButton = '<a href="'.route('task.revoke', $tasks->id).'" class="btn btn-sm btn-warning revoke"> <i class="fas fa-ban"></i></a> ';
                            }

                            $buttons =
                                '<a href="'.route('task.download', ['id' => $tasks->id]).'" class="btn btn-sm btn-info"><i class="fas fa-download"></i></a> '.
                                '<a href="'.route('task.edit', $tasks->id).'" class="btn btn-sm btn-success"> <i class="fas fa-pencil-alt"></i></a> '.
                                '<a href="'.route('task.destroy', $tasks->id).'" class="btn btn-sm btn-danger delete"><i class="fas fa-times"></i></a> '.
                                $revokeButton;

                            return $buttons;
                        })
                        ->toJson();

        return $datatables;
    }

    /**
     * Get not booked tasks with datatables format
     *
     * @return json
     */
    public function notBookedDatatables()
    {
        $tasks = $this::whereNull('annotator_id')->orderBy('created_at', 'desc');

        $datatables = DataTables::eloquent($tasks)
                        ->addColumn('action', function($task){
                            $buttons = '<a href="'.route('annotator.task.book', $task->id).'" class="btn btn-sm btn-primary book"> <i class="fas fa-book"></i></a> ';
                            return $buttons;
                        })
                        ->toJson();
        return $datatables;
    }

    /**
     * Modify static create function for generate task name automaticly
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->name = $model->generateName();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    /**
     * Booking Task
     *
     * @return void
     */
    public function book()
    {
        $annotatorID = auth()->guard('annotator')->user()->id;

        $this->annotator_id = $annotatorID;
        $this->update();
    }
}
