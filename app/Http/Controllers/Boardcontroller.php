<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Phase;
use Illuminate\Http\Request;

class Boardcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        //
        return response()->json([
            'status'=>200,
            'boards'=>Board::where('user_id',$userId)->get(),
        
        ]);
          
       
    }


    /**
     * Store a newly created resource in storage.
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // create a Board
        $field = $request->validate([

            'Board'=>'string|required',
        ]);
        $Board = Board::create([

            'board_name'=>$field['Board'],
            'user_id' => $id,
        ]);

        return response()->json(
            [
                'message' => 'Board ' . $Board->board_name . ' created successfully',
                'Board' => $Board,
                'status'=> 201,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $boardId
     * @return \Illuminate\Http\Response
     */
    public function show($boardId)
    {
        //
        $Board = Board::with('phase.tasks.subtasks')->find($boardId);
              
            return response()->json([
                
                    'message'=>'Board successfuly fetched',
                    'boards'=> $Board,
                    'status'=>200,
                
            
                
            ]);

      
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

            'board'=> 'string|required',
        ]);

        $Board = new Board;
        $Board = Board::where('id', $id)->update(['board_name'=>$field['board']]);

        if($Board):

            return response([
               'msg'=> 'Board id ' . $id .' updated successfully',
               ['Board'=> $field['board']],
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

        $Board = new Board();
       $fetchBoard = $Board->where('id', $id)->first();


        if(empty($fetchBoard)):
    

                 return response ([

                    'message' =>  'Board does not exist',

                 ]);
            else:

            if(!empty($fetchBoard)):

                $Board->where('id', $id)->with('phases')->with('tasks')->with('subtasks')->delete();

                return response ()->json([

                    'Message' => 'Board was delected successfuly',
                    'status'=>200,

                ]);

            endif;

    endif;

    
    }
}
 