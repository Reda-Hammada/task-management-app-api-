<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class Taskcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  int  $board_id

     * @return \Illuminate\Http\Response
     */
    public function index($board_id)
    {
        //
        $Tasks = Tasks::where('board_id', $board_id)->get();

        return response([
            
            'tasks'=> $Tasks,

        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *@param  int  $board_id

     * @return \Illuminate\Http\Response
     */
    public function create($board_id)
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
     * @param  int  $board_id
     * @return \Illuminate\Http\Response
     */

    public function show($board_id)
    {
        //
        $Tasks = Tasks::where('board_id', $board_id)->get();

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
