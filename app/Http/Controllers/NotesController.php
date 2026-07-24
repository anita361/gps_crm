<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NotesController extends Controller
{


    public function getNotes(Request $request)
    {
        $notes = DB::table('notes_logs')
            ->select(
                'main_id',
                'notes_remarks as remarks',
                'created_name as updated_by',
                'created_datetime as datetime',
                'commission_status',
                'comm_one_amt',
                'comm_two_amt'
            )
            ->where('main_id', $request->note_id)
            ->orderByDesc('created_datetime')
            ->get();

        return response()->json([
            'status' => true,
            'notes' => $notes
        ]);
    }
    

    public function addNote(Request $request)
    {
        $request->validate([
            'note_id' => 'required',
            'newNote' => 'required'
        ]);


        $userId = Session::get('login');


        $user = DB::table('crm_login')->where('id', $userId)->first();
        $createdName = $user->name ?? 'Unknown';

        DB::table('notes_logs')->insert([
            'main_id'          => $request->note_id,
            'notes_remarks'    => $request->newNote,


            'created_id'       => $userId ?? 0,
            'created_name'     => $createdName,

            'created_date'     => now()->format('Y-m-d'),
            'created_datetime' => now()->format('Y-m-d H:i:s'),

            'commission_status' => '',
            'comm_one_amt'      => 0,
            'comm_two_amt'      => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Note Added Successfully'
        ]);
    }
}
