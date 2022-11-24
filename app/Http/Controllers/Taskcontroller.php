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
     * @param int $phase_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$phase_id)
    {
        //
        $field = $request->validate([

            'task'=>'required|string'
        ]);

       $Task = new Tasks();
       
       $Task->task_name = $field['task'];
       $Task->phase_id = $phase_id;
       $Task->save();

       return response([
        'msg' => 'Task ' . $field['task'] . ' has been successfully created',
       ],201);






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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // validate the request 
        $field = $request->validate([

            'task'=>'required|string',
        ]);
        // get the specific task
        $Task = Tasks::where('id', $id)->first();

        // check if it exists with the id provided from the front-end 
        if(!empty($Task)):

            $task = new Tasks();
            $task->where('id',$id)->
            update(['task_name'=>$field['task']]);
            

            return response([
                
                'msg' => $Task['task_name'] . ' Has been updated succesfully',

            ],200);
        

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
        $Task = new Tasks();
        $fetchedTask = $Task->where('id', $id)->first();

        if(!empty($fetchedTask)):

            $Task->where('id',$id)
            ->delete();

            return response(['msg'=>$fetchedTask['task_name'] . ' has been deleted successfuly ']);
        endif;
    }
}
