<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Models\Note;

class NoteController extends Controller
{
    public function listNotes(Request $request) 
    {
        $date = $request->has('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        
        $notes = Note::whereDate('date', $date)
                        ->orderBy('created_at', 'ASC')
                        ->get();

        return response($notes);
    }

    public function createNote(Request $request)
    {
        $date = ($request->has('date') && $request->input('date') != 'today') ? Carbon::parse($request->input('date')) : Carbon::today();

        try {
            $name = "notes/" . Str::uuid()->toString() . ".txt";
            $file = Storage::put($name, $request->input('contents'));

            $note = Note::create([
                'date' => $date,
                'name' => $request->input('name'),
                'note' => $name
            ]);

            return response([
                'error' => false,
                'message' => 'Note has been created successfully'
            ]);
        } catch(\Throwable $e) {
            return response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateNote(Request $request, $id)
    {
        logger()->debug('Title: ' . $request->input('name'));
        try {
            $note = Note::find($id);
            $name = $note->note ?? '';
            if(empty($name)) {
                $name = "notes/" . Str::uuid()->toString() . ".txt";
            }
            $file = Storage::put($name, $request->input('contents'));

            $note->update([
                'name' => $request->input('name'),
                'note' => $name
            ]);

            return response([
                'error' => false,
                'message' => 'Note has been updated successfully!'
            ]);
        } catch(\Throwable $e) {
            return response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function viewContent($id)
    {
        try {
            $note = Note::find($id);
            $file = Storage::get($note->note);

            return response([
                'error' => false,
                'id' => $note->id,
                'name' => $note->name,
                'content' => $file
            ]);
        } catch(\Throwable $e) {
            return response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteNote($id)
    {
        $note = Note::find($id);
        if(Storage::exists($note->note)) {
            Storage::delete($note->note);
        }
        $note->delete();

        return response([
            'error' => false,
            'message' => 'Note has been deleted successfully!'
        ]);
    }
}
