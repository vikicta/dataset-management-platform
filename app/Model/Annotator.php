<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class Annotator extends Authenticatable
{
    protected $guard = "annotator";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relation to task
     *
     * @return eloquent
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'annotator_id', 'id')->with('annotator');
    }


    /**
     * Set password with Hashed Password
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get all annotator and adding edit and delete button with datatables format
     *
     * @return json
     */
    public function allDatatables()
    {
        $datatables = DataTables::collection($this::all())
                            ->addColumn('action', function($annotator){
                                return
                                '<a href="'.route('annotator.edit', $annotator->id).'" class="btn btn-sm btn-success"> <i class="fas fa-pencil-alt"></i></a> '.
                                '<a href="'.route('annotator.destroy', $annotator->id).'" class="btn btn-sm btn-danger delete"><i class="fas fa-times"></i></a>';
                            })
                            ->toJson();

        return $datatables;
    }

    /**
     * Update Annotator
     *
     * \Illuminate\Http\Request  $request
     * @return void
     */

     public function updateCustom($request)
     {
         // Password will not be update if it's null
         if (is_null($request->password)) {

            $request = $request->except(['password']);

         } else {

            $request = $request->all();

         }

         $this->update($request);
     }

     /**
     * Get specific annotator tasks with datatables format
     *
     * @return json
     */
    public function myTasksDatatables()
    {
        $tasks = $this->tasks;

        $datatables = DataTables::collection($tasks)
                        ->addColumn('action', function($task){
                            $buttons = '<a href="'.route('annotator.task.download', ['id' => $task->id]).'" class="btn btn-sm btn-info"><i class="fas fa-download"></i></a> ';
                            return $buttons;
                        })
                        ->toJson();

        return $datatables;
    }

}
