<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\AolEnrolledExport;
use Maatwebsite\Excel\Facades\Excel;

class OperationController extends Controller
{
    /**
     * AOL Enrolled Dashboard
     */
    // public function aolEnrolledStatus(Request $request)
    // {
    //     $query = DB::table('seminarpre')
    //         ->where('student_status', 'enrolled');

    //     // Date Filter
    //     if ($request->filled('GetFltDate')) {
    //         $query->whereDate('start_date', $request->GetFltDate);
    //     }

    //     // Operation Status
    //     if ($request->filled('operation_status')) {
    //         $query->where('opr_stage', $request->operation_status);
    //     }

    //     // Fund Status
    //     if ($request->filled('fund_aol_status')) {
    //         $query->where('fund_aol_status', $request->fund_aol_status);
    //     }

    //     // Province
    //     if ($request->filled('province_name')) {
    //         $query->where('province_name', $request->province_name);
    //     }


    //     if ($request->filled('collage_name')) {
    //         $query->where('collage_name', $request->collage_name);
    //     }

    //     if ($request->filled('campus_name')) {
    //         $query->where('campus_name', $request->campus_name);
    //     }


    //     if ($request->filled('prg_name')) {
    //         $query->where('prg_name', $request->prg_name);
    //     }


    //     if ($request->filled('counselor_id')) {
    //         $query->where('assign_id', $request->counselor_id);
    //     }


    //     $data = $query
    //         ->orderByDesc('enrolled_date')
    //         ->get();


    //     $colleges = DB::table('college_list')
    //         ->select('clg_name')
    //         ->distinct()
    //         ->orderBy('clg_name')
    //         ->get();


    //     $counselors = DB::table('crm_login')
    //         ->where('role', 'counselor')
    //         ->orderBy('name')
    //         ->get();

    //     return view('operation.dashboard', compact(
    //         'data',
    //         'colleges',
    //         'counselors'
    //     ));
    // }
    public function aolEnrolledStatus(Request $request)
{
    $query = DB::table('seminarpre')
        ->select(
            'sno',
            'sname',
            'smobile',
            'scountry',
            'assign_name',
            'assign_id',
            'file_no',
            'semail',
            'collage_name',
            'campus_name',
            'program_name',
            'province_name',
            'start_date',
            'end_date',
            'opr_stage',
            'opr_stage_date',
            'opr_stage_remarks',
            'stage_update_name',
            'oprStsSend',
            'fund_aol_status',
            'osap_status',
            'student_status',
            'enrolled_date'
        )
        ->where('student_status', 'enrolled');

    // Start Date
    if ($request->filled('GetFltDate')) {
        $query->whereDate('start_date', $request->GetFltDate);
    }

    // Operation Status
    if ($request->filled('operation_status')) {
        $query->where('opr_stage', $request->operation_status);
    }

    // Main Status
    if ($request->filled('fund_aol_status')) {
        $query->where('fund_aol_status', $request->fund_aol_status);
    }

    // Province
    if ($request->filled('province_name')) {
        $query->where('province_name', $request->province_name);
    }

    // College
    if ($request->filled('collage_name')) {
        $query->where('collage_name', $request->collage_name);
    }

    // Campus
    if ($request->filled('campus_name')) {
        $query->where('campus_name', $request->campus_name);
    }

    // Program
    if ($request->filled('program_name')) {
        $query->where('program_name', $request->program_name);
    }

    // Counselor
    if ($request->filled('counselor_id')) {
        $query->where('assign_id', $request->counselor_id);
    }

    $data = $query
        ->orderBy('enrolled_date', 'DESC')
        ->get();

    $colleges = DB::table('college_list')
        ->select('clg_name')
        ->distinct()
        ->orderBy('clg_name')
        ->get();

    $counselors = DB::table('crm_login')
        ->where('role', 'counselor')
        ->orderBy('name')
        ->get();

    return view('operation.dashboard', compact(
        'data',
        'colleges',
        'counselors'
    ));
}


    public function updateOperationStatus(Request $request)
    {
        $request->validate([
            'semi_id' => 'required',
            'status'  => 'required',
            'date'    => 'required',
        ]);

        DB::table('seminarpre')
            ->where('sno', $request->semi_id)
            ->update([
                'opr_stage'          => $request->status,
                'opr_stage_date'     => $request->date,
                'opr_stage_remarks'  => $request->remarks,
                'stage_update_name'  => Auth::user()->name,
                'oprStsSend'         => $request->oprStsSend,
            ]);
        DB::table('opr_sts_logs')->insert([
            'main_id'      => $request->semi_id,
            'stage'        => $request->status,
            'stage_date'   => $request->date,
            'created_name' => Auth::user()->name ?? 'Admin',
            'created_id'   => Auth::id(),
            'created_at'   => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Operation Status Updated Successfully'
        ]);
    }

    public function updateFundStatus(Request $request)
    {
        $request->validate([
            'semi_id' => 'required',
            'status'  => 'required',
            'date'    => 'required',
        ]);

        DB::table('seminarpre')
            ->where('sno', $request->semi_id)
            ->update([
                'fund_aol_status' => $request->status
            ]);

        DB::table('fund_status_logs')->insert([
            'main_id'      => $request->semi_id,
            'status'       => $request->status,
            'status_date'  => $request->date,
            'created_name' => Auth::user()->name ?? 'Admin',
            'created_id'   => Auth::id(),
            'created_at'   => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Fund Status Updated Successfully'
        ]);
    }


    public function addNote(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'note'       => 'required',
        ]);

        DB::table('notes_logs')->insert([
            'student_id' => $request->student_id,
            'notes'      => $request->note,
            'created_by' => Auth::user()->name ?? 'Admin',
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Note Added Successfully'
        ]);
    }


    public function getNotes(Request $request)
    {
        $notes = DB::table('notes_logs')
            ->where('student_id', $request->student_id)
            ->orderByDesc('id')
            ->get();

        $html = '';

        if ($notes->count() > 0) {

            foreach ($notes as $note) {

                $html .= '
                <div class="card mb-2">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <strong>' . $note->created_by . '</strong>

                            <small>' . $note->created_at . '</small>

                        </div>

                        <hr>

                        <p class="mb-0">' . $note->notes . '</p>

                    </div>

                </div>';
            }
        } else {

            $html = '
            <div class="alert alert-info text-center mb-0">

                No Notes Found

            </div>';
        }

        return response($html);
    }

    /**
     * Operation Status Logs
     */
    public function operationLogs(Request $request)
    {
        $logs = DB::table('opr_sts_logs')
            ->where('main_id', $request->semi_id)
            ->orderByDesc('id')
            ->get();

        $html = '';

        if ($logs->count() > 0) {

            foreach ($logs as $row) {

                $html .= '
                <tr>
                    <td>' . $row->stage . '</td>
                    <td>' . $row->stage_date . '</td>
                    <td>' . $row->created_name . '</td>
                    <td>' . $row->created_at . '</td>
                </tr>';
            }
        } else {

            $html = '
            <tr>
                <td colspan="4" class="text-center">
                    No Records Found
                </td>
            </tr>';
        }

        return response($html);
    }

    /**
     * Fund Status Logs
     */
    public function fundStatusLogs(Request $request)
    {
        $logs = DB::table('fund_status_logs')
            ->where('main_id', $request->semi_id)
            ->orderByDesc('id')
            ->get();

        $html = '';

        if ($logs->count() > 0) {

            foreach ($logs as $row) {

                $html .= '
                <tr>
                    <td>' . $row->status . '</td>
                    <td>' . $row->status_date . '</td>
                    <td>' . $row->created_name . '</td>
                    <td>' . $row->created_at . '</td>
                </tr>';
            }
        } else {

            $html = '
            <tr>
                <td colspan="4" class="text-center">
                    No Records Found
                </td>
            </tr>';
        }

        return response($html);
    }

    /**
     * Get Campus List
     */
    public function getCampuses($college)
    {
        $campuses = DB::table('college_list')
            ->where('clg_name', $college)
            ->select('campus_name')
            ->distinct()
            ->orderBy('campus_name')
            ->get();

        $html = '<option value="">Select Campus</option>';

        foreach ($campuses as $campus) {

            $html .= '<option value="' . $campus->campus_name . '">'
                . $campus->campus_name .
                '</option>';
        }

        return response($html);
    }

    /**
     * Get Program List
     */
    public function getPrograms($college, $campus)
    {
        $programs = DB::table('program_list')
            ->where('clg_name', $college)
            ->where('campus_name', $campus)
            ->select('prg_name')
            ->distinct()
            ->orderBy('prg_name')
            ->get();

        $html = '<option value="">Select Program</option>';

        foreach ($programs as $program) {

            $html .= '<option value="' . $program->prg_name . '">'
                . $program->prg_name .
                '</option>';
        }

        return response($html);
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        return Excel::download(
            new AolEnrolledExport(),
            'AOL_Enrolled_List.xlsx'
        );
    }
}
