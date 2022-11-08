<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Phase;
use Illuminate\Http\Request;

class Boardcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     * @param int $user_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
    
        // create a Board

          $field = $request->validate([

            'Board'=>'string|required',
        ]);
        $Board = Board::create([

            'board_name'=>$field['Board'],
            'user_id' => $user_id,
        ]);

        return response([
            'message' => 'Board ' . $Board->board_name . ' created successfully',
            ['Board' => $Board],
        ]);
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
        $Board = Board::where('user_id', $id)->get();
        


            return response([

                'boards'=> $Board,
            
            ],200);

        if(empty($Board)):
            
            return response([

                'message'=> 'user' . $id . ' has no boards or user not found',

            ], 400);

        endif;
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

            'board'=> 'string|required',
        ]);

        $Board = new Board;
        $Board = Board::where('id', $id)->update(['board_name'=>$field['board']]);

        if($Board):

            return response([
               'msg'=> 'Board id ' . $id .' updated successfully',
               ['Board'=> $field['board']],
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

        $Board = new Board();
       $fetchBoard = $Board->where('id', $id)->first();


        if(empty($fetchBoard)):
    

                 return response ([
                    'message' =>  'Board does not exist',
                 ]);
            else:

            if(!empty($fetchBoard)):

                $Board->where('id', $id)->delete();

                return response ([

                    'Message' => 'Board was delected successfuly'
                ]);
            endif;

    endif;

    
    }
}
 