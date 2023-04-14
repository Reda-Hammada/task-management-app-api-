<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tasks;
use App\Models\Subtasks;


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
    public function store(Request $request,$phase_id){
        
        $field = $request->validate([

            'title'=>'string|required',
            'description' =>'string',
            
        ]);

         $Task = new Tasks();
       
         // title 
           $Task->task_name = $field['title'];
           $Task->phase_id = $phase_id;
           $Task->save();
        
        // description 
           
       if(isset($field['description'])):

            $Task->description = $field['description'];
            $Task->save();
        
        endif;
 

       // Subtasks 
        foreach($request->except(['title','description']) as $key => $value):
            
          //  checking if there is Subtask exist in the request since we are expecting unexpected indexed named array (Subtask1,Subtask2,Subtask3 ...)
            if(strpos($key, 'Subtask') === 0    ):
                    // then validate all the Subtasks in the request 
                $validatedSubtask = Validator::make(['Subtask'=> $value],[
                    'Subtask' => 'string'
                    
                ])->validate();
 
                // then store it in the database 
                $Subtask = new Subtasks();
                $Subtask->subtask_name = $validatedSubtask['Subtask'];
                $Subtask->task_id =  $Task->id;
                $Subtask->save();
                
            endif;
             
        endforeach;

       return response([
        'msg' => 'Task ' . $field['title'] . ' has been successfully created',
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