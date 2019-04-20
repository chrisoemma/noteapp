<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Validator;

class NotesController extends Controller
{

    //create new article
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
        $response = $this->successfulMessage(201, 'Successfully created', true, $note->count(), $note);
        return response($response);

    }
    //return those which are not deleted
    public function allnotes()
    {

        $notes = Note::all();
        $response = $this->successfulMessage(200, 'Successfully', true, $notes->count(), $notes);

        return response($response);
    }

    //first permanent delete

    public function permanentDelete($id)
    {

        $note = Note::destroy($id);
        if ($note) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $note);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softdelete($id)
    {

        $note = Note::destroy($id);
        if ($note) {
            $response = $this->successfulMessage(200, 'Successfully deleted', true,0, $note);
        } else {

            $response = $this->notFoundMessage();

        }
        return response($response);
    }
    //returns both non-deleted and softdeleted
    public function notesWithSoftDelete()
    {

        $notes = Note::withTrashed()->get();
        $response = $this->successfulMessage(200, 'Successfully', true, $notes->count(), $notes);
        return response($response);

    }

    public function softdeleted()
    {
        $notes = Note::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $notes->count(), $notes);
        return response($response);
    }

    public function restore($id)
    {

        $note = Note::onlyTrashed()->find($id);

        if (!is_null($note)) {

            $note->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $note->count(), $note);
        } else {

            return response($response);
        }
        return response($response);
    }

    public function permanentDeleteSoftDeleted($id)
    {
        $note = Note::onlyTrashed()->find($id);

        if (!is_null($note)) {

            $note->forceDelete();
            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $note);
        } else {

            return response($response);
        }
        return response($response);
    }

    private function notFoundMessage()
    {

        return [
            'code' => 404,
            'message' => 'Note not found',
            'success' => false,
        ];

    }

    private function successfulMessage($code, $message, $status, $count, $payload)
    {

        return [
            'code' => $code,
            'message' => $message,
            'success' => $status,
            'count' => $count,
            'data' => $payload,
        ];

    }

}