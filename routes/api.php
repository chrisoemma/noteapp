<?php

Route::post('/v1/notes', 'NotesController@create');
Route::get('/v1/notes', 'NotesController@allNotes');
Route::delete('v1/notes/{id}', 'NotesController@permanentDelete'); //this on first permanent delete models
Route::delete('v2/notes/{id}', 'NotesController@softDelete');
Route::get('v2/notes/withsoftdelete','NotesController@notesWithSoftDelete');
Route::get('v2/notes/softdeleted','NotesController@softDeleted');
Route::patch('/v1/notes/{id}','NotesController@restore');
Route::delete('v3/notes/{id}','NotesController@permanentDeleteSoftDeleted');