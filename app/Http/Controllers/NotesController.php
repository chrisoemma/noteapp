<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Validator;

class NotesController extends Controller
{
    //
    public function create(Request $request){
           
           $rules=[
        'name'=>'required|string',
         ];

         $validator=Validator::make($request->all(),$rules);
         if($validator->fails()){
         	 $response['data'] = $validator->messages();
           return $response;
         }

         $note=new Note;
         $note->name=$request->name;
          $note->save();

            $response=[
          	  'code'=>200,
          	'success'=>true,
          	'data'=>$note
          ];
          return response($response);

      }

    public function allnotes(){
          
          $notes=Note::all();

          $response=[
          	  'code'=>200,
          	'success'=>true,
          	 'count'=>$notes->count(),
          	'data'=>$notes
          ];
    	 return response($response);
    }

    public function permanentDelete($id){

          $note= Note::destroy($id);
            if($note){
            $response=[
          	  'code'=>200,
          	  'message'=>'Succesfuly deleted',
          	'success'=>true,
          ];
          }else{
                 $response=[
          	  'code'=>404,
          	  'message'=>'Note not found',
          	'success'=>false,
          ]; 
  
          }
           return response($response);
           
      }


}
