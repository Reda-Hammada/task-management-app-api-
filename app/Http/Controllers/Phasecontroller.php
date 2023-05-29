<?php

namespace App\Http\Controllers;
use App\Models\Tasks;
use App\Models\Phase;
use Illuminate\Http\Request;

class Phasecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *@param int $board_id 
     * @return \Illuminate\Http\Response
     */
    public function index($board_id)
    {
        //
        $Phase = Phase::where('board_id', $board_id)->get();

        if(!empty($Phase)):

            return response([
            
                'msg'=> [$Phase],
    
            ]);
            
        endif;
    }

   
    /**
     * Store a newly created resource in storage.
     * @param int $boardId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$boardId)
    {
        //
        $field = $request->validate([
            
            'phase' => 'string|required',
            
            
        ]);


            $phase = new Phase();
            $phase->create(
                            ['phase'=> $field['phase'],
                            'board_id'=> $boardId, ]
                        );



            return response([
                'msg' => 'phase created ' . $phase['phase'] . ' successfuly',
               
            ],201); 
    
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
        
        // set validation 
        $field = $request->validate([

            'phase' => 'string|required',

        ]);

        // if validated 
        if($field):
            // fetch the specific phase with id 
           
            $Phase= Phase::where('id', $id)->first();

                if(!empty($Phase)):

                    $Updatephase = new Phase();
                    $Updatephase->where('id', $id)->update(['phase'=>$field['phase']]);
                    
                    return response()->json(
                        [
                            'msg' => 'Phase ' . $Phase['phase'] . ' has been updated',
                            'status'=> 200,
    
                        ]
                    );

                endif;
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
        $Phase = Phase::where('id', $id)->first();

        if(!empty($Phase)):

            $deletePhase = new Phase();

            $deletePhase->where('id', $id)->delete();


            return response()->json(
                [
                'status'=>200,
                "msg"=> $Phase['phase'] . ' deleted successfully',
                ]
        );

        

        endif;

        
    }
}