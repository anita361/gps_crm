<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class CsvUploadController extends Controller

{



    public function showForm()

    {

        return view('leads.upload_csv');
    }

    public function leadList()

    {

        $counselors = DB::table('crm_login')

            ->where('role', 'counselor')

            ->orderBy('name')

            ->get();



        $leads = DB::table('lead_appointed')

            ->orderByDesc('id')

            ->paginate(50);



        return view('leads.lead_list', compact('leads', 'counselors'));
    }





    public function seminarList(Request $request)
    {
        $limit = $request->limit ?? 50;

        $seminars = DB::table('lead_appointed')
            ->where('no_accompanying', '!=', '')
            ->orderBy('created_date', 'desc')
            ->paginate($limit);

        return view('leads.seminar_list', compact('seminars', 'limit'));
    }

    public function seminarDownload()
    {
        $fileName = 'seminar_leads.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Client Name',
                'Client Email',
                'Province',
                'Mobile No',
                'Created Date',
                'Apply From',
                'RSVP Name',
                'Accompanying NO'
            ]);

            $rows = DB::table('lead_appointed')
                ->where('no_accompanying', '!=', '')
                ->orderBy('created_date', 'desc')
                ->get();

            foreach ($rows as $row) {
                fputcsv($file, [
                    $row->applicant_name,
                    $row->email,
                    $row->province_name,
                    $row->callerno,
                    $row->created_date . ' ' . $row->created_time,
                    $row->lead_from,
                    $row->rep_name_via,
                    $row->no_accompanying,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    public function assignLead(Request $request)

    {




        $request->validate([

            'counselor_id' => 'required|integer|exists:crm_login,id',

        ], [

            'counselor_id.required' => 'Please select a counselor.',

            'counselor_id.exists'   => 'Selected counselor is invalid.',

        ]);





        if (!$request->has('enro_st_id') || empty($request->enro_st_id)) {

            return response("

            <script>

                alert('Please Check First!');

                window.history.back();

            </script>

        ");
        }



        $counselor_id = (int) $request->counselor_id;

        $leadIds = $request->enro_st_id;



        $created_date = now()->toDateString();

        $created_time = now()->format('H:i:s');



        DB::beginTransaction();



        try {



            $counselor = DB::table('crm_login')

                ->where('id', $counselor_id)

                ->first();



            if (!$counselor) {

                return back()->with('error', 'Counselor not found.');
            }



            $name = $counselor->name;



            foreach ($leadIds as $leadID) {
            }



            DB::commit();



            return redirect()->route('lead.list')

                ->with('success', 'Lead assigned successfully.');
        } catch (\Exception $e) {



            DB::rollBack();



            return back()->with('error', $e->getMessage());
        }
    }


    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');

        if (($handle = fopen($file->getRealPath(), "r")) === false) {
            return back()->with('error', 'Unable to open CSV.');
        }

        $inserted = 0;
        $duplicate = 0;
        $skipped = 0;
        $row = 0;
        $debug = [];

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {

            $row++;


            if ($row == 1) {
                continue;
            }

            if (count($data) < 4) {
                $skipped++;
                $debug[] = "Row {$row}: Less than 4 columns.";
                continue;
            }



            $first_name = trim($data[0] ?? '');
            $last_name  = trim($data[1] ?? '');
            $mobile     = preg_replace('/[^0-9]/', '', $data[2] ?? '');
            $email      = trim($data[3] ?? '');
            $remarks    = trim($data[4] ?? '');

            if ($first_name == '') {
                $skipped++;
                $debug[] = "Row {$row}: First name empty.";
                continue;
            }

            if ($mobile == '') {
                $skipped++;
                $debug[] = "Row {$row}: Mobile empty.";
                continue;
            }

            if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;
                $debug[] = "Row {$row}: Invalid email ({$email}).";
                continue;
            }

            $exists = DB::table('lead_appointed')
                ->where('callerno', $mobile)
                ->exists();

            if ($exists) {
                $duplicate++;
                $debug[] = "Row {$row}: Duplicate mobile ({$mobile}).";
                continue;
            }

            DB::table('lead_appointed')->insert([
                'callerno'       => $mobile,
                'walkin_status'  => 3,
                'applicant_name' => trim($first_name . ' ' . $last_name),
                'email'          => $email,
                'lead_from'      => 'CSV',
                'lead_remarsk'   => $remarks,
                'created_date'   => now()->toDateString(),
                'created_time'   => now()->toTimeString(),
            ]);

            $inserted++;
            $debug[] = "Row {$row}: Inserted successfully.";
        }

        fclose($handle);

        return redirect()->route('lead.list')->with([
            'success' => "Upload Complete: {$inserted} inserted, {$duplicate} duplicate, {$skipped} skipped.",
            'debug'   => implode('<br>', $debug),
        ]);
    }

    public function leadTransfer(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Check Login
        |--------------------------------------------------------------------------
        */

        if (!session('role')) {

            return redirect()->route(
                'logout'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Manager Only
        |--------------------------------------------------------------------------
        */

        if (
            session('role') !==
            'branch_manager'
        ) {

            return redirect()->route(
                'logout'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Today
        |--------------------------------------------------------------------------
        */

        $today =
            Carbon::today()->format(
                'Y-m-d'
            );


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $filterType =
            $request->get(
                'filter_type',
                'today'
            );


        $leadName =
            trim(
                $request->get(
                    'lead_name',
                    ''
                )
            );


        $fromDate =
            trim(
                $request->get(
                    'from_date',
                    ''
                )
            );


        $toDate =
            trim(
                $request->get(
                    'to_date',
                    ''
                )
            );


        $status =
            trim(
                $request->get(
                    'status',
                    'Pending'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Limit
        |--------------------------------------------------------------------------
        */

        $limit =
            (int) $request->get(
                'limit',
                50
            );


        if (
            !in_array(
                $limit,
                [
                    10,
                    25,
                    50,
                    100
                ]
            )
        ) {

            $limit = 50;
        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            DB::table(
                'lead_transfer_requests as r'
            );


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $status !== '' &&
            $status !== 'All'
        ) {

            $query->where(
                'r.status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Lead Name Filter
        |--------------------------------------------------------------------------
        */

        if ($leadName !== '') {

            $query->where(
                'r.lead_name',
                'LIKE',
                '%' . $leadName . '%'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Today Filter
        |--------------------------------------------------------------------------
        */

        if (
            $filterType ===
            'today'
        ) {

            $query->whereDate(
                'r.created_at',
                $today
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Previous Date Filter
        |--------------------------------------------------------------------------
        */

        if (
            $filterType ===
            'previous'
        ) {

            if (
                $fromDate !== ''
            ) {

                $query->whereDate(
                    'r.created_at',
                    '>=',
                    $fromDate
                );
            }


            if (
                $toDate !== ''
            ) {

                $query->whereDate(
                    'r.created_at',
                    '<=',
                    $toDate
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Get Requests
        |--------------------------------------------------------------------------
        */

        $transfers =
            $query
            ->select(
                'r.*'
            )
            ->orderBy(
                'r.created_at',
                'desc'
            )
            ->paginate(
                $limit
            )
            ->appends(
                $request->except(
                    'page'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Blade
        |--------------------------------------------------------------------------
        */

        return view(
            'leads.transfer_lead_request',
            compact(
                'transfers',
                'filterType',
                'leadName',
                'fromDate',
                'toDate',
                'status',
                'limit'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCEPT / REJECT TRANSFER REQUEST
    |--------------------------------------------------------------------------
    */

    public function leadTransferAction(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */

        if (!session('role')) {

            return response()->json([

                'status' =>
                'error',

                'message' =>
                'Session expired.'

            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Manager Check
        |--------------------------------------------------------------------------
        */

        if (
            session('role') !==
            'branch_manager'
        ) {

            return response()->json([

                'status' =>
                'error',

                'message' =>
                'Unauthorized action.'

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'action' => [
                'required',
                'in:accept,reject'
            ],

            'reason' => [
                'nullable',
                'string',
                'max:1000'
            ]

        ]);


        /*
        |--------------------------------------------------------------------------
        | Find Transfer Request
        |--------------------------------------------------------------------------
        */

        $transfer =
            DB::table(
                'lead_transfer_requests'
            )
            ->where(
                'id',
                $id
            )
            ->first();


        if (!$transfer) {

            return response()->json([

                'status' =>
                'error',

                'message' =>
                'Transfer request not found.'

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Already Processed
        |--------------------------------------------------------------------------
        */

        if (
            $transfer->status !==
            'Pending'
        ) {

            return response()->json([

                'status' =>
                'error',

                'message' =>
                'This transfer request has already been processed.'

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ACCEPT
        |--------------------------------------------------------------------------
        */

        if (
            $request->action ===
            'accept'
        ) {


            DB::beginTransaction();


            try {


                /*
                |--------------------------------------------------------------------------
                | Update Transfer Request
                |--------------------------------------------------------------------------
                */

                DB::table(
                    'lead_transfer_requests'
                )
                    ->where(
                        'id',
                        $id
                    )
                    ->update([

                        'status' =>
                        'Accepted',

                        'updated_at' =>
                        now()

                    ]);


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | If your original PHP approve file changes the actual lead
                | counselor here, put that exact query here.
                |
                | Example:
                |
                | DB::table('leads')
                |     ->where('id', $transfer->lead_id)
                |     ->update([
                |         'counselor_id' => $transfer->requested_by_id,
                |         'updated_at' => now()
                |     ]);
                |
                |--------------------------------------------------------------------------
                */


                DB::commit();


                return response()->json([

                    'status' =>
                    'success',

                    'message' =>
                    'Lead transfer request accepted successfully.'

                ]);
            } catch (\Throwable $e) {


                DB::rollBack();


                Log::error(
                    'Lead Transfer Accept Error: ' .
                        $e->getMessage()
                );


                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Unable to accept transfer request.'

                ], 500);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | REJECT
        |--------------------------------------------------------------------------
        */

        if (
            $request->action ===
            'reject'
        ) {


            $reason =
                trim(
                    $request->reason ?? ''
                );


            if (
                $reason === ''
            ) {

                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Rejection reason is required.'

                ]);
            }


            try {


                DB::table(
                    'lead_transfer_requests'
                )
                    ->where(
                        'id',
                        $id
                    )
                    ->update([

                        'status' =>
                        'Rejected',

                        'rejection_reason' =>
                        $reason,

                        'updated_at' =>
                        now()

                    ]);


                return response()->json([

                    'status' =>
                    'success',

                    'message' =>
                    'Lead transfer request rejected successfully.'

                ]);
            } catch (\Throwable $e) {


                Log::error(
                    'Lead Transfer Reject Error: ' .
                        $e->getMessage()
                );


                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Unable to reject transfer request.'

                ], 500);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Invalid Action
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' =>
            'error',

            'message' =>
            'Invalid transfer action.'

        ], 400);
    }
}
