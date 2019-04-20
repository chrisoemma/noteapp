<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/notes', 'NotesController@create');
Route::get('/v1/notes', 'NotesController@allnotes');
Route::delete('v1/notes/{id}', 'NotesController@permanentDelete'); //this on first permanent delete models
Route::delete('v2/notes/{id}', 'NotesController@softdelete');
Route::get('v2/notes/withsoftdelete','NotesController@notesWithSoftDelete');
Route::get('v2/notes/softdeleted','NotesController@softdeleted');
Route::patch('/v1/notes/{id}','NotesController@restore');
Route::patch('v2/notes/{id}','NotesController@permanentDeleteSoftDeleted');