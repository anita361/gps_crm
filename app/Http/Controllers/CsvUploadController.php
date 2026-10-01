<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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



        if (!session('role')) {

            return redirect()->route(
                'logout'
            );
        }




        if (
            session('role') !==
            'branch_manager'
        ) {

            return redirect()->route(
                'logout'
            );
        }



        $today =
            Carbon::today()->format(
                'Y-m-d'
            );



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




        $query =
            DB::table(
                'lead_transfer_requests as r'
            );


        if (
            $status !== '' &&
            $status !== 'All'
        ) {

            $query->where(
                'r.status',
                $status
            );
        }



        if ($leadName !== '') {

            $query->where(
                'r.lead_name',
                'LIKE',
                '%' . $leadName . '%'
            );
        }



        if (
            $filterType ===
            'today'
        ) {

            $query->whereDate(
                'r.created_at',
                $today
            );
        }




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




    public function leadTransferAction(
        Request $request,
        $id
    ) {



        if (!session('role')) {

            return response()->json([
                'status' => 'error',
                'message' => 'Session expired.'
            ], 401);
        }




        if (session('role') !== 'branch_manager') {

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.'
            ], 403);
        }



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




        $id = (int) $id;

        if ($id <= 0) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request ID.'
            ], 400);
        }




        $managerId = (int) session('login');




        $manager = DB::table('crm_login')
            ->where('id', $managerId)
            ->first();


        if (!$manager) {

            return response()->json([
                'status' => 'error',
                'message' => 'Branch manager not found.'
            ], 404);
        }


        $managerName = trim(
            $manager->name ?? ''
        );




        $transfer = DB::table(
            'lead_transfer_requests'
        )
            ->where('id', $id)
            ->first();


        if (!$transfer) {

            return response()->json([
                'status' => 'error',
                'message' => 'Transfer request not found.'
            ], 404);
        }



        if ($transfer->status !== 'Pending') {

            return response()->json([
                'status' => 'error',
                'message' =>
                'This transfer request has already been processed.'
            ], 422);
        }




        if ($request->action === 'accept') {


            $leadId = (int) $transfer->lead_id;

            $newCounselorId = (int) $transfer->requested_by_id;

            $newCounselorName = trim(
                $transfer->requested_by_name ?? ''
            );

            $originalCounselorId = (int) (
                $transfer->current_counselor_id ?? 0
            );




            $lead = DB::table('seminarpre')
                ->select([
                    'sno',
                    'sname',
                    'smobile',
                    'assign_id',
                    'assign_name'
                ])
                ->where('sno', $leadId)
                ->first();


            if (!$lead) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Lead not found in seminarpre.',
                    'lead_id' => $leadId
                ], 404);
            }



            $actualCurrentCounselorId = (int) (
                $lead->assign_id ?? 0
            );


            if (
                $actualCurrentCounselorId !==
                $originalCounselorId
            ) {

                return response()->json([
                    'status' => 'error',
                    'message' =>
                    'This lead has already been reassigned. '
                        . 'The transfer request can no longer be accepted.'
                ], 422);
            }



            DB::beginTransaction();


            try {


                $leadUpdated = DB::table('seminarpre')
                    ->where('sno', $leadId)
                    ->where('assign_id', $originalCounselorId)
                    ->update([

                        'assign_id' =>
                        $newCounselorId,

                        'assign_name' =>
                        $newCounselorName,

                        'assign_date' =>
                        now(),

                        'update_date' =>
                        now()->toDateString(),

                        'update_time' =>
                        now()->format('H:i:s')

                    ]);


                if ($leadUpdated <= 0) {

                    throw new \Exception(
                        'Unable to update lead assignment.'
                    );
                }



                $requestUpdated = DB::table(
                    'lead_transfer_requests'
                )
                    ->where('id', $id)
                    ->where('status', 'Pending')
                    ->update([

                        'status' =>
                        'Accepted',

                        'approved_by_id' =>
                        $managerId,

                        'approved_by_name' =>
                        $managerName,

                        'approved_at' =>
                        now(),

                        'updated_at' =>
                        now()

                    ]);


                if ($requestUpdated <= 0) {

                    throw new \Exception(
                        'Transfer request was not updated. '
                            . 'It may already have been processed.'
                    );
                }



                DB::commit();


                return response()->json([

                    'status' =>
                    'success',

                    'message' =>
                    'Lead transfer request accepted successfully.',

                    'lead_id' =>
                    $leadId,

                    'new_counselor_id' =>
                    $newCounselorId,

                    'new_counselor_name' =>
                    $newCounselorName

                ]);
            } catch (\Throwable $e) {


                DB::rollBack();


                Log::error(
                    'Lead Transfer Accept Error',
                    [
                        'transfer_request_id' =>
                        $id,

                        'lead_id' =>
                        $leadId,

                        'error' =>
                        $e->getMessage()
                    ]
                );


                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Unable to accept transfer request.'

                ], 500);
            }
        }



        if ($request->action === 'reject') {


            $reason = trim(
                $request->reason ?? ''
            );




            if ($reason === '') {

                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Rejection reason is required.'

                ], 422);
            }


            try {



                $updated = DB::table(
                    'lead_transfer_requests'
                )
                    ->where('id', $id)
                    ->where('status', 'Pending')
                    ->update([

                        'status' =>
                        'Rejected',

                        'rejection_reason' =>
                        $reason,

                        'approved_by_id' =>
                        $managerId,

                        'approved_by_name' =>
                        $managerName,

                        'approved_at' =>
                        now(),

                        'updated_at' =>
                        now()

                    ]);




                if ($updated <= 0) {

                    return response()->json([

                        'status' =>
                        'error',

                        'message' =>
                        'This transfer request has already been processed.'

                    ], 422);
                }



                return response()->json([

                    'status' =>
                    'success',

                    'message' =>
                    'Lead transfer request rejected successfully.'

                ]);
            } catch (\Throwable $e) {


                Log::error(
                    'Lead Transfer Reject Error',
                    [
                        'transfer_request_id' =>
                        $id,

                        'error' =>
                        $e->getMessage()
                    ]
                );


                return response()->json([

                    'status' =>
                    'error',

                    'message' =>
                    'Unable to reject transfer request.'

                ], 500);
            }
        }



        return response()->json([

            'status' =>
            'error',

            'message' =>
            'Invalid action.'

        ], 400);
    }

    public function requestLeadTransfer(Request $request)
    {

        if (!session()->has('login')) {

            return response()->json([
                'status' => 'error',
                'message' => 'Session expired. Please login again.'
            ], 401);
        }



        if (session('role') !== 'counselor') {

            return response()->json([
                'status' => 'error',
                'message' => 'Only counselors can request lead transfer.'
            ], 403);
        }




        $request->validate([
            'lead_id' => [
                'required',
                'integer'
            ]
        ]);



        $requesterId = (int) session('login');



        $requester = DB::table('crm_login')
            ->where('id', $requesterId)
            ->first();


        if (!$requester) {

            return response()->json([
                'status' => 'error',
                'message' => 'Counselor not found.'
            ], 404);
        }



        $requesterName = trim(
            $requester->name ?? ''
        );

        $requesterBranch = trim(
            $requester->branch ?? ''
        );



        $leadId = (int) $request->lead_id;



        $lead = DB::table('seminarpre')
            ->select([
                'sno',
                'sname',
                'smobile',
                'assign_id',
                'assign_name'
            ])
            ->where('sno', $leadId)
            ->first();




        if (!$lead) {

            return response()->json([
                'status' => 'error',
                'message' => 'Lead not found.'
            ], 404);
        }



        $currentAssignId = (int) (
            $lead->assign_id ?? 0
        );

        $currentAssignName = trim(
            $lead->assign_name ?? ''
        );




        $leadName = trim(
            $lead->sname ?? ''
        );

        $leadMobile = trim(
            $lead->smobile ?? ''
        );



        if ($currentAssignId === $requesterId) {

            return response()->json([
                'status' => 'error',
                'message' => 'You already own this lead.'
            ], 422);
        }



        $existingRequest = DB::table(
            'lead_transfer_requests'
        )
            ->where('lead_id', $leadId)
            ->where('requested_by_id', $requesterId)
            ->where('status', 'Pending')
            ->first();


        if ($existingRequest) {

            return response()->json([
                'status' => 'error',
                'message' => 'Transfer request is already pending.'
            ], 422);
        }




        try {

            DB::table(
                'lead_transfer_requests'
            )->insert([

                'lead_id' =>
                $leadId,

                'lead_name' =>
                $leadName,

                'lead_mobile' =>
                $leadMobile,

                'current_counselor_id' =>
                $currentAssignId,

                'current_counselor_name' =>
                $currentAssignName,

                'requested_by_id' =>
                $requesterId,

                'requested_by_name' =>
                $requesterName,

                'requested_branch' =>
                $requesterBranch,

                'status' =>
                'Pending',

                'created_at' =>
                now(),

                'updated_at' =>
                now()

            ]);



            return response()->json([

                'status' =>
                'success',

                'message' =>
                'Transfer request sent successfully.'

            ]);
        } catch (\Throwable $e) {

            Log::error(
                'Lead Transfer Request Error',
                [
                    'lead_id' =>
                    $leadId,

                    'requester_id' =>
                    $requesterId,

                    'error' =>
                    $e->getMessage()
                ]
            );


            return response()->json([

                'status' =>
                'error',

                'message' =>
                'Unable to create transfer request.'

            ], 500);
        }
    }
}
