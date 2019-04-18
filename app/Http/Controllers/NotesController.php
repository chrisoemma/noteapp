<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class NotesController extends Controller
{
    //
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
}
