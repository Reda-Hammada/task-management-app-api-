<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;

class Phasecontroller extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param int $board_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$board_id)
    {
        //
        $field = $request->validate([
            
            'phase' => 'string|required',
            
            
        ]);

        if($field):

            $phase = new Phase();
            $phase->create(
                            ['phase'=> $field['phase'],
                            'board_id'=> $board_id, ]
                        );
        endif;

        if($phase){

            return response([
                'msg' => 'phase created ' . $phase['phase'] . ' successfuly',
                ['phase' => $field['phase']],
            ],201);
        }
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
