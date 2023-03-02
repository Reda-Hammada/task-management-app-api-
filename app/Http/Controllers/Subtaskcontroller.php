<?php

namespace App\Http\Controllers;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Models\Subtasks;

class Subtaskcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
    public function index($task_id)
    {
        //

        $Subtasks = new Subtasks();
        $Subtasks->where('task_id', $task_id)->get();

        return response([
            'subtasks' => $Subtasks,
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
     * @param int $task_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $task_id)
    {
        //
        // data validation 
        $fields = $request->validate([

            'subtask' => 'string|required',
        ]);

       

                Subtasks::create([
                    
                 'subtask_name' => $fields['subtask'],
                 'task_id' => $task_id,
    
                ]);
    
                return response(

                    ['msg' => $fields['subtask'] .' has been created successfully'],201);


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
        $field = $request->validate([

            'subtask' => 'string|required',
        ]);

        $Subtask = Subtasks::where(

            'id', $id,
        )
        ->first();

        if(!empty($Subtask)):

            $updateSubtask = new Subtasks();

            $updateSubtask->where('id',$id)
            ->update(
                [

                'subtask_name'=>$field['subtask']
                
                ]
            );

            return response([

                'msg' => $Subtask['subtask_name'] . ' has been successfully udpated',
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

        $Subtask = new Subtasks();
        
        $Subtask->where('id', $id)
        ->first();  

        if(!empty($Subtask)):

            $delete = new Subtasks();
            $delete->where('id', $id)
            ->delete();
        endif;


        return response([

            'msg' => 'Subtask has been deleted'

        ],200);
    }
}