<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class Taskcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  int  $phase_id

     * @return \Illuminate\Http\Response
     */
    public function index($phase_id)
    {
        //
        $Tasks = Tasks::where('phase_id', $phase_id)->get();

        return response([
            
            'tasks'=> $Tasks,

        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *

     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create tasks 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $phase_id
     * @return \Illuminate\Http\Response
     */

    public function show($phase_id)
    {
        //
        $Tasks = Tasks::where('phase_id', $phase_id)->get();

        return response([

            'tasks'=> $Tasks,

        ], 200);
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
     * @param  int  $phase_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $phase_id)
    {
        //
        // validate the request 
        $field = $request->validate([

            'task'=>'required|string',
        ]);
        // get the specific task
        $Task = Tasks::where('phase_id', $phase_id)->get();

        // check if it exists with the id provided from the front-end 
        if(!empty($Task)):

            $task = new Tasks();
            $task->update(['task_name'=>$field['task']])->where('phase_id',$phase_id);

            return response([
                
                'msg' => $Task . ' Has been updated succesfully',
                
            ]);

        endif;

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
