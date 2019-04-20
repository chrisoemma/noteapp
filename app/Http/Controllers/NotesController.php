<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Validator;

class NotesController extends Controller
{
    //
    public function create(Request $request)
    {

        $rules = [
            'name' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }

        $note = new Note;
        $note->name = $request->name;
        $note->save();

        $response = [
            'code' => 201,
            'message' => 'Succesfuly created',
            'success' => true,
            'data' => $note,
        ];
        return response($response);

    }
    //return those which are not deleted
    public function allnotes()
    {

        $notes = Note::all();

        $response = [
            'code' => 200,
            'success' => true,
            'count' => $notes->count(),
            'data' => $notes,
        ];
        return response($response);
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $note = Note::destroy($id);
        if ($note) {
            $response = [
                'code' => 200,
                'message' => 'Succesfuly deleted',
                'success' => true,
            ];
        } else {
            $response = [
                'code' => 404,
                'message' => 'Note not found',
                'success' => false,
            ];

        }
        return response($response);
    }

    public function softdelete($id)
    {

        $note = Note::destroy($id);
        if ($note) {
            $response = [
                'code' => 200,
                'message' => 'Succesfuly deleted',
                'success' => true,
            ];
        } else {
            $response = [
                'code' => 404,
                'message' => 'Note not found',
                'success' => false,
            ];

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function notesWithSoftDelete()
    {

        $notes = Note::withTrashed()->get();

        $response = [
            'code' => 200,
            'success' => true,
            'count' => $notes->count(),
            'data' => $notes,
        ];
        return response($response);

    }

    public function softdeleted()
    {
        $notes = Note::onlyTrashed()->get();

        $response = [
            'code' => 200,
            'success' => true,
            'count' => $notes->count(),
            'data' => $notes,
        ];
        return response($response);
    }

    public function restore($id)
    {

        $note = Note::onlyTrashed()->find($id);

        if (!is_null($note)) {
            $note->restore();
            $response = [
                'code' => 200,
                'message' => 'Succesfuly restored',
                'success' => true,
                'data' => $note,
            ];
        } else {

            $response = [
                'code' => 404,
                'message' => 'Note not found',
                'success' => false,
            ];
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $note = Note::onlyTrashed()->find($id);

        if (!is_null($note)) {
            $note->forceDelete();
            $response = [
                'code' => 200,
                'message' => 'Succesfuly deleted',
                'success' => true,
                'data' => $note,
            ];
        } else {

            $response = [
                'code' => 404,
                'message' => 'Note not found',
                'success' => false,
            ];
        }
        return response($response);
    }

}
