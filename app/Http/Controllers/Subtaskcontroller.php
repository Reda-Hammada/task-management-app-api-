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
        $Subtasks = Subtasks::where('task_id', $task_id)->get();

        if ($Subtasks->count() > 0) {
            // Subtasks found
            return response()->json([
                'subtasks' => $Subtasks,
                'status' => 200,
            ]);
        } else {
            // No subtasks found
            return response()->json([
                'message' => 'No subtasks found',
                'status' => 404,
            ]);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {       
        //
        $Subtask = Subtasks::where(

            'id', $id,
        )
        ->first();


        if($request['subtask']):
            $field = $request->validate([
                'subtask' => 'string'
            ]);
            
            $Subtask->subtask_name = $field['subtask'];
            $Subtask->save();
            return response()
                    ->json([
                        'msg' =>'Subtask has been successfully udpated',
                        'status'=> 200,
                        
                    ]);

        endif;
        
        if($request['isDone']):
            $field = $request->validate([
                'isDone' => 'boolean'
            ]);
             
            $Subtask->isDone = $field['isDone'];
            $Subtask->save();
            return response()
            ->json([
                'msg' =>'Subtask status has been updated',
                'status'=> 200,
                'isDone' => $Subtask->isDone            
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