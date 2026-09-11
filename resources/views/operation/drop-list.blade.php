@extends('layouts.app')

@section('title', 'Drop List')

@section('content')

    @php
        $userRole = auth()->user()->role ?? '';
        $username = auth()->user()->username ?? '';

        $allowedExcelUsers = [
            'branch_manager',
            'sahil_arora',
            'navjot',
            'prabjot'
        ];

        $operationStatuses = [
            'Not Process',
            'Campus Login',
            'VeriFast & Wonderlic',
            'Contract',
            'Orientation',
            'FAO Appointment',
            'Drop',
        ];

        $mainStatuses = [
            'Start',
            'FR1',
            'FR2',
            'Cancel',
            'Withdrawal'
        ];

        $provinceList = $provinces ?? [
            'Alberta',
            'British Columbia',
            'Manitoba',
            'New Brunswick',
            'Newfoundland and Labrador',
            'Northwest Territories',
            'Nova Scotia',
            'Nunavut',
            'Ontario',
            'Prince Edward Island',
            'Quebec',
            'Saskatchewan',
            'Yukon',
        ];
    @endphp


    <style>

        .card-header {
            background: #3164d9;
            color: #fff;
        }

        .card-header h5 {
            font-weight: 500;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(6, minmax(150px, 1fr));
            gap: 8px;
        }

        .filter-col label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .filter-col .form-control,
        .filter-col .form-select {
            width: 100%;
            height: 32px;
            font-size: 12px;
        }

        .filter-buttons {
            display: flex;
            align-items: end;
            gap: 5px;
        }

        #opr_table {
            white-space: nowrap;
            font-size: 12px;
        }

        #opr_table th {
            vertical-align: middle;
            background: #f5f5f5;
        }

        #opr_table td {
            vertical-align: middle;
        }

        #opr_table .form-control,
        #opr_table .form-select {
            min-width: 110px;
            height: 32px;
            font-size: 12px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .pagination {
            margin-bottom: 0;
        }

        .loading-option {
            color: #777;
        }

        @media (max-width: 1200px) {

            .filter-row {
                grid-template-columns: repeat(3, minmax(180px, 1fr));
            }

        }

        @media (max-width: 768px) {

            .filter-row {
                grid-template-columns: repeat(1, 1fr);
            }

        }


        /* =========================================================
           LOG MODALS
        ========================================================= */

        .logs-modal-content {
            border: 0;
            border-radius: 5px;
            overflow: hidden;
        }

        .logs-modal-content .modal-header {
            padding: 14px 18px;
            border-bottom: 1px solid #ddd;
            background: #fff;
        }

        .logs-modal-content .modal-title {
            font-size: 16px;
            font-weight: 500;
            color: #555;
        }

        .logs-modal-content .modal-body {
            padding: 12px 14px 18px;
            background: #fff;
        }

        .logs-section-title {
            background: #4a4a4a;
            color: #fff;
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            padding: 6px 10px;
        }

        .logs-table {
            width: 100%;
            margin: 0;
            border: 1px solid #d5d5d5;
            font-size: 13px;
        }

        .logs-table thead th {
            background: #303030;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
            padding: 8px 10px;
            border: 1px solid #555;
            white-space: nowrap;
        }

        .logs-table tbody td {
            padding: 8px 10px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #d5d5d5;
        }

        .logs-table tbody tr:nth-child(even) {
            background: #f7f7f7;
        }

        .logs-table tbody tr:hover {
            background: #eef3ff;
        }

        .logs-table tbody tr:first-child {
            background: #3164d9;
            color: #fff;
        }

        .logs-table tbody tr:first-child td {
            border-color: #3164d9;
        }

        .logs-table tbody tr td[colspan] {
            background: #fff !important;
            color: #555 !important;
        }

        @media (max-width: 768px) {

            .logs-modal-content .modal-body {
                padding: 8px;
            }

            .logs-table {
                font-size: 12px;
            }

            .logs-table thead th,
            .logs-table tbody td {
                padding: 6px;
            }

        }

    </style>

    <div class="card">

        <div class="card-header text-center">

            <h5 class="mb-0">
                Drop List
            </h5>

        </div>


        <div class="card-body">


            <form action="{{ route('drop.list') }}" method="GET" id="operation_status_form">

                <div class="filter-row">
                    <div class="filter-col">

                        <label for="FromFltDate">
                            From Start Date:
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="FromFltDate"
                            name="FromFltDate"
                            value="{{ request('FromFltDate') }}"
                        >

                    </div>


                    {{-- To Date --}}
                    <div class="filter-col">

                        <label for="ToFltDate">
                            To Start Date:
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="ToFltDate"
                            name="ToFltDate"
                            value="{{ request('ToFltDate') }}"
                        >

                    </div>


                    {{-- Operation Status --}}
                    <div class="filter-col">

                        <label for="operation_status">
                            Operation Status:
                        </label>

                        <select
                            class="form-control"
                            id="operation_status"
                            name="operation_status"
                        >

                            <option value="">
                                Select
                            </option>

                            @foreach ($operationStatuses as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ request('operation_status') == $status ? 'selected' : '' }}
                                >
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Student Status --}}
                    <div class="filter-col">

                        <label for="student_status">
                            Student Status:
                        </label>

                        <select
                            class="form-control"
                            id="student_status"
                            name="student_status"
                        >

                            <option value="">
                                Select
                            </option>

                            <option
                                value="enrolled"
                                {{ request('student_status') == 'enrolled' ? 'selected' : '' }}
                            >
                                Enrolled
                            </option>

                            <option
                                value="Re-enrolled"
                                {{ request('student_status') == 'Re-enrolled' ? 'selected' : '' }}
                            >
                                Re-enrolled
                            </option>

                        </select>

                    </div>


                    {{-- Main Status --}}
                    <div class="filter-col">

                        <label for="fund_aol_status">
                            Main Status:
                        </label>

                        <select
                            class="form-control"
                            id="fund_aol_status"
                            name="fund_aol_status"
                        >

                            <option value="">
                                Select Status
                            </option>

                            @foreach ($mainStatuses as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ request('fund_aol_status') == $status ? 'selected' : '' }}
                                >
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Province --}}
                    <div class="filter-col">

                        <label for="province_name">
                            Province:
                        </label>

                        <select
                            name="province"
                            id="province_name"
                            class="form-control"
                        >

                            <option value="">
                                --Select Province--
                            </option>

                            @foreach ($provinceList as $province)

                                <option
                                    value="{{ $province }}"
                                    {{ request('province') == $province ? 'selected' : '' }}
                                >
                                    {{ $province }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- College --}}
                    <div class="filter-col">

                        <label for="collage_name">
                            College:
                        </label>

                        <select
                            name="college"
                            id="collage_name"
                            class="form-control"
                        >

                            <option value="">
                                --Select College--
                            </option>

                            @foreach ($colleges ?? [] as $college)

                                <option
                                    value="{{ $college->clg_name }}"
                                    {{ request('college') == $college->clg_name ? 'selected' : '' }}
                                >
                                    {{ $college->clg_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Campus --}}
                    <div class="filter-col">

                        <label for="campus">
                            Campus:
                        </label>

                        <select
                            name="campus"
                            id="campus"
                            class="form-control"
                        >

                            <option value="">
                                --Select Campus--
                            </option>

                        </select>

                    </div>


                    {{-- Program --}}
                    <div class="filter-col">

                        <label for="program_name">
                            Program:
                        </label>

                        <select
                            name="program"
                            id="program_name"
                            class="form-control"
                        >

                            <option value="">
                                --Select Program--
                            </option>

                        </select>

                    </div>


                    {{-- Counselor --}}
                    <div class="filter-col">

                        <label for="assign">
                            Counselor Wise:
                        </label>

                        <select
                            name="counselor_id"
                            id="assign"
                            class="form-control"
                        >

                            <option value="">
                                Select a Counselor
                            </option>

                            @foreach ($counselors ?? [] as $counselor)

                                <option
                                    value="{{ $counselor->id }}"
                                    {{ request('counselor_id') == $counselor->id ? 'selected' : '' }}
                                >
                                    {{ $counselor->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- OPR Last Status Date --}}
                    <div class="filter-col">

                        <label for="GetFltDate">
                            Opr Last Status Date:
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="GetFltDate"
                            id="GetFltDate"
                            value="{{ request('GetFltDate') }}"
                        >

                    </div>


                    {{-- Search --}}
                    <div class="filter-col">

                        <label for="Getsearch">
                            Name / Phone / Country / File No:
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="Getsearch"
                            id="Getsearch"
                            value="{{ request('Getsearch') }}"
                            placeholder="Search..."
                        >

                    </div>


                    {{-- Buttons --}}
                    <div class="filter-col filter-buttons">

                        <button
                            type="submit"
                            class="btn btn-success btn-sm"
                        >
                            Search
                        </button>

                        <a
                            href="{{ route('drop.list') }}"
                            class="btn btn-secondary btn-sm"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </form>


            {{-- =========================================================
                EXCEL
            ========================================================== --}}

            @if (in_array($username, $allowedExcelUsers))

                <form
                    action="{{ route('drop.excel') }}"
                    method="POST"
                    class="mt-3"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="where_condition"
                        value="{{ $where_condition ?? '' }}"
                    >

                    <button
                        type="submit"
                        class="btn btn-primary btn-sm"
                    >
                        Download In Excel
                    </button>

                </form>

            @endif


            {{-- =========================================================
                DATA
            ========================================================== --}}

            <div id="alldata" class="mt-4">


                {{-- Entries --}}
                <div class="mb-2">

                    <select
                        id="limitSelect"
                        class="form-select form-select-sm"
                        style="width:auto;display:inline-block;"
                    >

                        @foreach ([10, 25, 50, 100] as $limitOption)

                            <option
                                value="{{ $limitOption }}"
                                {{ (int) request('limit', $limit ?? 10) === $limitOption ? 'selected' : '' }}
                            >
                                {{ $limitOption }}
                            </option>

                        @endforeach

                    </select>

                    <span class="ms-2">
                        entries
                    </span>

                </div>


                {{-- =====================================================
                    TABLE
                ====================================================== --}}

                <div class="table-responsive">

                    <table
                        id="opr_table"
                        class="table table-striped table-bordered table-hover"
                        width="100%"
                    >

                        <thead>

                            <tr>

                                <th>Notes</th>
                                <th>Client Name</th>
                                <th>Client Number</th>
                                <th>Country Name</th>
                                <th>Counselor Name</th>
                                <th>File Number</th>
                                <th>Student Status</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>Campus</th>
                                <th>Program Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Opr Last Status Date</th>
                                <th>Opr Last Remarks</th>
                                <th>Opr Status Update By</th>
                                <th>Operation Status</th>
                                <th>CL</th>
                                <th>Status Update Logs</th>

                                @if ($userRole !== 'counselor')
                                    <th>View</th>
                                @endif

                                <th>Main Status</th>
                                <th>Main Status Logs</th>
                                <th>Finance Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($students ?? [] as $row)

                                <tr>


                                    {{-- Notes --}}
                                    <td>

                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm open-notes-modal"
                                            data-file-no="{{ $row->sno }}"
                                            data-name="{{ $row->sname }}"
                                        >
                                            Notes
                                        </button>

                                    </td>


                                    {{-- Client Name --}}
                                    <td>
                                        {{ $row->sname ?? '' }}
                                    </td>


                                    {{-- Client Number --}}
                                    <td>
                                        {{ $row->smobile ?? '' }}
                                    </td>


                                    {{-- Country --}}
                                    <td>
                                        {{ $row->scountry ?? '' }}
                                    </td>


                                    {{-- Counselor --}}
                                    <td>
                                        {{ $row->assign_name ?? '' }}
                                    </td>


                                    {{-- File Number --}}
                                    <td>
                                        {{ $row->file_no ?? '' }}
                                    </td>


                                    {{-- Student Status --}}
                                    <td>
                                        {{ $row->student_status ?? '' }}
                                    </td>


                                    {{-- Email --}}
                                    <td>
                                        {{ $row->semail ?? '' }}
                                    </td>


                                    {{-- College --}}
                                    <td>
                                        {{ $row->collage_name ?? '' }}
                                    </td>


                                    {{-- Campus --}}
                                    <td>
                                        {{ $row->campus_name ?? '' }}
                                    </td>


                                    {{-- Program --}}
                                    <td>
                                        {{ $row->program_name ?? '' }}
                                    </td>


                                    {{-- Start Date --}}
                                    <td>
                                        {{ $row->start_date ?? '' }}
                                    </td>


                                    {{-- End Date --}}
                                    <td>
                                        {{ $row->end_date ?? '' }}
                                    </td>


                                    {{-- Operation Last Status Date --}}
                                    <td>
                                        {{ $row->opr_stage_date ?? '' }}
                                    </td>


                                    {{-- Operation Last Remarks --}}
                                    <td>
                                        {{ $row->opr_stage_remarks ?? '' }}
                                    </td>


                                    {{-- Updated By --}}
                                    <td>
                                        {{ $row->stage_update_name ?? '' }}
                                    </td>


                                    {{-- Operation Status --}}
                                    <td>

                                        @if ($userRole === 'counselor')

                                            <select class="form-control" disabled>

                                                <option value="{{ $row->opr_stage ?? '' }}">
                                                    {{ $row->opr_stage ?? '' }}
                                                </option>

                                            </select>

                                        @else

                                            <select
                                                class="form-control status-select"
                                                data-file-no="{{ $row->sno }}"
                                                data-file-name="{{ $row->sname ?? '' }}"
                                                data-file-email="{{ $row->semail ?? '' }}"
                                                data-mobile="{{ $row->smobile ?? '' }}"
                                                data-assign-name="{{ $row->assign_name ?? '' }}"
                                            >

                                                <option value="">
                                                    Select
                                                </option>

                                                @foreach ($operationStatuses as $status)

                                                    <option
                                                        value="{{ $status }}"
                                                        {{ ($row->opr_stage ?? '') == $status ? 'selected' : '' }}
                                                    >
                                                        {{ $status }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        @endif

                                    </td>


                                    {{-- CL --}}
                                    <td class="text-success">

                                        @if (
                                            ($row->opr_stage ?? '') === 'Campus Login'
                                            || isset($row->campus_login_done)
                                        )

                                            <strong>
                                                Done
                                            </strong>

                                        @endif

                                    </td>

                                    <td>

                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm view-operation-logs-btn"
                                            data-file-no="{{ $row->sno }}"
                                            data-name="{{ $row->sname ?? '' }}"
                                        >
                                            Status Update Logs
                                        </button>

                                    </td>

                                    @if ($userRole !== 'counselor')

                                        <td>

                                            <a
                                                href="{{ route('walking-details', [
                                                    'smobile' => $row->smobile,
                                                    'semi_id' => $row->sno,
                                                ]) }}"
                                                class="btn btn-primary btn-sm"
                                            >
                                                View
                                            </a>

                                        </td>

                                    @endif


                                    <td>

                                        @if (in_array($username, ['prabjot', 'navjot']))

                                            <span>
                                                {{ $row->fund_aol_status ?? '' }}
                                            </span>

                                        @else

                                            <select
                                                class="form-control fund_aol_status"
                                                data-file-no="{{ $row->sno }}"
                                                data-file-name="{{ $row->sname ?? '' }}"
                                                data-file-email="{{ $row->semail ?? '' }}"
                                            >

                                                <option value="">
                                                    Select Status
                                                </option>

                                                @foreach ($mainStatuses as $status)

                                                    <option
                                                        value="{{ $status }}"
                                                        {{ ($row->fund_aol_status ?? '') == $status ? 'selected' : '' }}
                                                    >
                                                        {{ $status }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        @endif

                                    </td>

                                    <td>

                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm view-main-status-logs-btn"
                                            data-semi-id="{{ $row->sno }}"
                                            data-name="{{ $row->sname ?? '' }}"
                                        >
                                            Main Status Logs
                                        </button>

                                    </td>


                                    {{-- Finance Status --}}
                                    <td>
                                        {{ $row->osap_status ?? '' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="{{ $userRole !== 'counselor' ? 23 : 22 }}"
                                        class="text-center text-danger"
                                    >
                                        No records found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}

                @if ($students instanceof \Illuminate\Pagination\LengthAwarePaginator)

                    @php

                        $currentPage = $students->currentPage();
                        $perPage = $students->perPage();
                        $totalRecords = $students->total();

                        $from = $totalRecords > 0
                            ? ($currentPage - 1) * $perPage + 1
                            : 0;

                        $to = $totalRecords > 0
                            ? min($currentPage * $perPage, $totalRecords)
                            : 0;

                    @endphp


                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">

                        <div>

                            Showing
                            <strong>{{ $from }}</strong>
                            to
                            <strong>{{ $to }}</strong>
                            of
                            <strong>{{ $totalRecords }}</strong>
                            entries

                        </div>


                        <div>

                            {!! $students
                                ->onEachSide(2)
                                ->withQueryString()
                                ->links('pagination::bootstrap-5')
                            !!}

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
        STATUS UPDATE / OPERATION STATUS MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="statusModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Update Operation Status
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <form id="statusForm">

                        @csrf

                        <input
                            type="hidden"
                            id="file_no"
                            name="semi_id"
                        >

                        <input
                            type="hidden"
                            id="file_name"
                            name="file_name"
                        >

                        <input
                            type="hidden"
                            id="file_email"
                            name="file_email"
                        >

                        <input
                            type="hidden"
                            id="status"
                            name="status"
                        >

                        <input
                            type="hidden"
                            id="smobile_number"
                            name="smobile_number"
                        >

                        <input
                            type="hidden"
                            id="assign_name"
                            name="assign_name"
                        >


                        <div
                            class="mb-3"
                            id="oprStsSendDiv"
                            style="display:none;"
                        >

                            <label
                                for="oprStsSend"
                                class="form-label"
                                id="SendLabel"
                            ></label>

                            <select
                                class="form-control"
                                id="oprStsSend"
                                name="oprStsSend"
                            ></select>

                        </div>


                        <div class="mb-3">

                            <label
                                for="date"
                                class="form-label"
                            >
                                Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="date"
                                name="date"
                                value="{{ date('Y-m-d') }}"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="remarks"
                                class="form-label"
                            >
                                Remarks
                            </label>

                            <textarea
                                class="form-control"
                                id="remarks"
                                name="remarks"
                                rows="3"
                                required
                            ></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="statusSubmitBtn"
                        >
                            Submit
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        STATUS UPDATE LOGS MODAL
        IMPORTANT: UNIQUE ID
    ========================================================== --}}

    <div
        class="modal fade"
        id="operationLogsModal"
        tabindex="-1"
        aria-labelledby="operationLogsModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content logs-modal-content">


                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="operationLogsModalLabel"
                    >
                        Status Update Logs
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <div class="modal-body">


                    {{-- Operation Status Logs --}}
                    <div class="logs-section mb-4">

                        <div class="logs-section-title">
                            Status Update Logs
                        </div>


                        <div class="table-responsive">

                            <table class="table logs-table mb-0">

                                <thead>

                                    <tr>

                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Action Datetime</th>

                                    </tr>

                                </thead>


                                <tbody id="operationLogsTableBody">

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center"
                                        >
                                            No logs found.
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- Notes --}}
                    <div class="logs-section">

                        <div class="logs-section-title">
                            Notes
                        </div>


                        <div class="table-responsive">

                            <table class="table logs-table mb-0">

                                <thead>

                                    <tr>

                                        <th>Sno</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Action Datetime</th>

                                    </tr>

                                </thead>


                                <tbody id="operationLogsNotesBody">

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="text-center"
                                        >
                                            No notes found.
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN / AOL FUND STATUS UPDATE MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="aolFundModal"
        tabindex="-1"
        aria-labelledby="aolFundModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog">

            <form id="aolFundForm">

                @csrf

                <div class="modal-content">


                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="aolFundModalLabel"
                        >
                            Update Main Status
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="semi_id"
                            id="modal_semi_id"
                        >

                        <input
                            type="hidden"
                            name="fund_status"
                            id="modal_fund_status"
                        >


                        <div class="form-group mb-3">

                            <label for="fund_date">
                                Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="fund_date"
                                id="fund_date"
                                required
                            >

                        </div>


                        <div class="form-group mb-3">

                            <label for="fund_remarks">
                                Remarks
                            </label>

                            <textarea
                                class="form-control"
                                name="remarks"
                                id="fund_remarks"
                                rows="3"
                                required
                            ></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="aolFundSubmitBtn"
                        >
                            Update
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        MAIN STATUS LOGS MODAL
        IMPORTANT: UNIQUE ID
    ========================================================== --}}

    <div
        class="modal fade"
        id="aolLogsModal"
        tabindex="-1"
        aria-labelledby="aolLogsModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content logs-modal-content">


                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="aolLogsModalLabel"
                    >
                        Main Status Logs
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <div class="modal-body">

                    <div class="logs-section">

                        <div class="logs-section-title">
                            Main Status Logs
                        </div>


                        <div class="table-responsive">

                            <table class="table logs-table mb-0">

                                <thead>

                                    <tr>

                                        <th>Sno</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Changed By</th>
                                        <th>Changed At</th>

                                    </tr>

                                </thead>


                                <tbody id="aolLogsTableBody">

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center"
                                        >
                                            No logs found.
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        NOTES MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="notesModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Notes
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <form id="addNotesForm">

                        @csrf

                        <input
                            type="hidden"
                            name="note_id"
                            id="note_id"
                        >


                        <div class="mb-3">

                            <label for="newNote">
                                Remarks
                            </label>

                            <textarea
                                class="form-control"
                                name="newNote"
                                id="newNote"
                                rows="3"
                                required
                            ></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Note
                        </button>

                    </form>


                    <hr>


                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Sno</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                    <th>Action Datetime</th>

                                </tr>

                            </thead>


                            <tbody id="notesTableBody">

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center"
                                    >
                                        No notes found.
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

<script>

$(document).ready(function () {


    /* ============================================================
       CSRF
    ============================================================ */

    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (!csrfToken) {
        csrfToken = "{{ csrf_token() }}";
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });


    /* ============================================================
       COLLEGE -> CAMPUS
    ============================================================ */

    $('#collage_name').on('change', function () {

        let college = $(this).val();

        $('#campus').html(
            '<option value="">--Select Campus--</option>'
        );

        $('#program_name').html(
            '<option value="">--Select Program--</option>'
        );

        if (!college) {
            return;
        }

        $.ajax({

            url: "{{ route('osap.campuses') }}",

            type: "POST",

            data: {
                college_id: college,
                _token: csrfToken
            },

            success: function (response) {

                $('#campus').html(response);

                let selectedCampus = @json(request('campus'));

                if (selectedCampus) {

                    $('#campus')
                        .val(selectedCampus)
                        .trigger('change');

                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                $('#campus').html(
                    '<option value="">--Select Campus--</option>'
                );

                $('#program_name').html(
                    '<option value="">--Select Program--</option>'
                );

            }

        });

    });


    /* ============================================================
       CAMPUS -> PROGRAM
    ============================================================ */

    $('#campus').on('change', function () {

        let campus = $(this).val();
        let college = $('#collage_name').val();

        $('#program_name').html(
            '<option value="">--Select Program--</option>'
        );

        if (!college || !campus) {
            return;
        }

        $.ajax({

            url: "{{ route('osap.programs') }}",

            type: "POST",

            data: {
                college_id: college,
                campus_id: campus,
                _token: csrfToken
            },

            success: function (response) {

                $('#program_name').html(response);

                let selectedProgram = @json(request('program'));

                if (selectedProgram) {
                    $('#program_name').val(selectedProgram);
                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                $('#program_name').html(
                    '<option value="">--Select Program--</option>'
                );

            }

        });

    });


    /* ============================================================
       LOAD CAMPUS + PROGRAM AFTER SEARCH
    ============================================================ */

    let selectedCollege = $('#collage_name').val();

    let selectedCampus = @json(request('campus'));

    let selectedProgram = @json(request('program'));


    if (selectedCollege) {

        $.ajax({

            url: "{{ route('osap.campuses') }}",

            type: "POST",

            data: {
                college_id: selectedCollege,
                _token: csrfToken
            },

            success: function (response) {

                $('#campus').html(response);

                if (selectedCampus) {
                    $('#campus').val(selectedCampus);
                }

                if (selectedCampus) {

                    $.ajax({

                        url: "{{ route('osap.programs') }}",

                        type: "POST",

                        data: {
                            college_id: selectedCollege,
                            campus_id: selectedCampus,
                            _token: csrfToken
                        },

                        success: function (response) {

                            $('#program_name').html(response);

                            if (selectedProgram) {
                                $('#program_name').val(selectedProgram);
                            }

                        }

                    });

                }

            }

        });

    }


    /* ============================================================
       LIMIT
    ============================================================ */

    $('#limitSelect').on('change', function () {

        const limit = $(this).val();

        const url = new URL(window.location.href);

        url.searchParams.set('limit', limit);

        url.searchParams.delete('page');

        window.location.href = url.toString();

    });


    /* ============================================================
       OPERATION STATUS CHANGE
    ============================================================ */

    $(document).on('change', '.status-select', function () {

        const select = $(this);

        const status = select.val();

        if (!status) {
            return;
        }

        const semiId = select.attr('data-file-no');

        const fileName = select.attr('data-file-name');

        const fileEmail = select.attr('data-file-email');

        const mobile = select.attr('data-mobile');

        const assignName = select.attr('data-assign-name');


        $('#file_no').val(semiId);

        $('#file_name').val(fileName);

        $('#file_email').val(fileEmail);

        $('#status').val(status);

        $('#smobile_number').val(mobile);

        $('#assign_name').val(assignName);


        $('#remarks').val('');

        $('#date').val('{{ date('Y-m-d') }}');


        $('#oprStsSendDiv').hide();

        $('#oprStsSend').empty();


        const modalElement =
            document.getElementById('statusModal');

        const modal =
            bootstrap.Modal.getOrCreateInstance(modalElement);

        modal.show();

    });


    /* ============================================================
       OPERATION STATUS SUBMIT
    ============================================================ */

    $('#statusForm').on('submit', function (e) {

        e.preventDefault();

        const form = $(this);

        const button = $('#statusSubmitBtn');

        button
            .prop('disabled', true)
            .text('Submitting...');


        $.ajax({

            type: "POST",

            url: "{{ route('drop.update-status') }}",

            data: form.serialize(),

            success: function (response) {

                if (response.success) {

                    alert(
                        response.message ||
                        'Operation status updated successfully.'
                    );


                    const modalElement =
                        document.getElementById('statusModal');

                    bootstrap.Modal
                        .getOrCreateInstance(modalElement)
                        .hide();


                    location.reload();

                } else {

                    alert(
                        response.message ||
                        'Something went wrong.'
                    );

                }

            },

            error: function (xhr) {

                if (xhr.status === 422) {

                    let errors =
                        xhr.responseJSON?.errors || {};

                    let message = '';

                    $.each(errors, function (field, error) {

                        message += error[0] + "\n";

                    });

                    alert(message);

                } else {

                    alert(
                        xhr.responseJSON?.message ||
                        'Error updating operation status.'
                    );

                }

            },

            complete: function () {

                button
                    .prop('disabled', false)
                    .text('Submit');

            }

        });

    });


    /* ============================================================
       STATUS UPDATE LOGS
       THIS IS OPERATION STATUS LOGS
    ============================================================ */

    $(document).on(
        'click',
        '.view-operation-logs-btn',
        function () {

            const fileNo =
                $(this).attr('data-file-no');

            const name =
                $(this).attr('data-name') || '';


            console.log(
                'STATUS UPDATE LOG REQUEST:',
                {
                    semi_id: fileNo,
                    name: name
                }
            );


            /* Reset tables */

            $('#operationLogsTableBody').html(
                '<tr>' +
                '<td colspan="5" class="text-center">' +
                'Loading...' +
                '</td>' +
                '</tr>'
            );


            $('#operationLogsNotesBody').html(
                '<tr>' +
                '<td colspan="4" class="text-center">' +
                'Loading...' +
                '</td>' +
                '</tr>'
            );


            /* Modal title */

            $('#operationLogsModalLabel').text(
                'Status Update Logs' +
                (name ? ' - ' + name : '')
            );


            /* Open correct modal */

            const modalElement =
                document.getElementById(
                    'operationLogsModal'
                );

            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    modalElement
                );

            modal.show();


            /* AJAX */

            $.ajax({

                url: "{{ route('drop.logs') }}",

                type: "POST",

                dataType: "json",

                data: {

                    _token: csrfToken,

                    semi_id: fileNo

                },


                success: function (response) {

                    console.log(
                        'STATUS UPDATE LOG RESPONSE:',
                        response
                    );


                    const logs =
                        Array.isArray(response.logs)
                            ? response.logs
                            : (
                                Array.isArray(response.data)
                                    ? response.data
                                    : []
                            );


                    const notes =
                        Array.isArray(response.notes)
                            ? response.notes
                            : (
                                Array.isArray(response.note_logs)
                                    ? response.note_logs
                                    : []
                            );


                    /* =================================================
                       OPERATION STATUS LOGS
                    ================================================= */

                 let logsHtml = '';

if (logs.length > 0) {

    $.each(logs, function (index, log) {

        logsHtml += `
            <tr>

                <td>
                    ${escapeHtml(log.date ?? '')}
                </td>

                <td>
                    ${escapeHtml(log.status ?? '')}
                </td>

                <td>
                    ${escapeHtml(log.remarks ?? '')}
                </td>

                <td>
                    ${escapeHtml(log.updated_by ?? '')}
                </td>

                <td>
                    ${escapeHtml(log.action_datetime ?? '')}
                </td>

            </tr>
        `;

    });

} else {

    logsHtml = `
        <tr>
            <td
                colspan="5"
                class="text-center text-danger"
            >
                No Status Update Logs Found
            </td>
        </tr>
    `;

}

$('#operationLogsTableBody').html(logsHtml);

                    /* =================================================
                       NOTES
                    ================================================= */

                    let notesHtml = '';


                    if (notes.length > 0) {

                        $.each(notes, function (index, note) {

                            notesHtml += `

                                <tr>

                                    <td>
                                        ${escapeHtml(
                                            note.sno ??
                                            note.id ??
                                            (index + 1)
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            note.remarks ??
                                            note.notes_remarks ??
                                            note.newNote ??
                                            ''
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            note.updated_by ??
                                            note.created_name ??
                                            note.name ??
                                            ''
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            note.action_datetime ??
                                            note.created_datetime ??
                                            note.created_at ??
                                            ''
                                        )}
                                    </td>

                                </tr>

                            `;

                        });

                    } else {

                        notesHtml = `

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center"
                                >
                                    No notes found.
                                </td>

                            </tr>

                        `;

                    }


                    $('#operationLogsNotesBody')
                        .html(notesHtml);

                },


                error: function (xhr) {

                    console.error(
                        'STATUS UPDATE LOG ERROR:',
                        xhr.status,
                        xhr.responseText
                    );


                    $('#operationLogsTableBody').html(`

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-danger"
                            >
                                Error loading Status Update Logs.
                            </td>

                        </tr>

                    `);


                    $('#operationLogsNotesBody').html(`

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-danger"
                            >
                                Error loading notes.
                            </td>

                        </tr>

                    `);

                }

            });

        }



        
    );





    let currentSelect = null;


    $(document).on(
        'change',
        '.fund_aol_status',
        function () {

            const $select = $(this);

            const semiId =
                $select.attr('data-file-no');

            const fundStatus =
                $select.val();


            currentSelect = $select;


            if (!fundStatus) {
                return;
            }


            $('#modal_semi_id')
                .val(semiId);

            $('#modal_fund_status')
                .val(fundStatus);

            $('#fund_date')
                .val('{{ date('Y-m-d') }}');

            $('#fund_remarks')
                .val('');


            const modalElement =
                document.getElementById(
                    'aolFundModal'
                );

            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    modalElement
                );

            modal.show();


            $('#aolFundModal')
                .off('hidden.bs.modal.mainstatus')
                .on(
                    'hidden.bs.modal.mainstatus',
                    function () {

                        if (currentSelect) {

                            /*
                             * Restore previous value when
                             * modal is cancelled.
                             *
                             * The page will reload after
                             * successful update.
                             */

                        }

                    }
                );

        }
    );


    /* ============================================================
       MAIN STATUS SUBMIT
    ============================================================ */

    $('#aolFundForm').on('submit', function (e) {

        e.preventDefault();


        const button =
            $('#aolFundSubmitBtn');


        button
            .prop('disabled', true)
            .text('Updating...');


        const data = {

            _token:
                $('input[name="_token"]', this).val(),

            semi_id:
                $('#modal_semi_id').val(),

            fund_status:
                $('#modal_fund_status').val(),

            fund_date:
                $('#fund_date').val(),

            remarks:
                $('#fund_remarks').val()

        };


        console.log(
            'MAIN STATUS DATA:',
            data
        );


        $.ajax({

            url: "{{ route('drop.update-status') }}",

            method: "POST",

            data: data,


            success: function (response) {

                console.log(
                    'MAIN STATUS RESPONSE:',
                    response
                );


                let result = response;

                if (typeof result === 'string') {
                    result = $.trim(result);
                }


                if (
                    result === 'success' ||
                    result?.success === true
                ) {

                    alert(
                        result?.message ||
                        'Main Status Updated Successfully!'
                    );


                    const modalElement =
                        document.getElementById(
                            'aolFundModal'
                        );

                    bootstrap.Modal
                        .getOrCreateInstance(
                            modalElement
                        )
                        .hide();


                    currentSelect = null;


                    location.reload();

                } else if (
                    result === 'no_change' ||
                    result?.status === 'no_change'
                ) {

                    alert(
                        'No changes detected.'
                    );

                } else {

                    alert(
                        result?.message ||
                        'Failed to update Main Status.'
                    );

                }

            },


            error: function (xhr) {

                console.error(
                    'MAIN STATUS ERROR:',
                    xhr.status,
                    xhr.responseText
                );


                if (xhr.status === 422) {

                    let errors =
                        xhr.responseJSON?.errors || {};

                    let message = '';

                    $.each(
                        errors,
                        function (field, error) {

                            message +=
                                error[0] + "\n";

                        }
                    );

                    alert(message);

                } else {

                    alert(
                        xhr.responseJSON?.message ||
                        'Failed to update Main Status.'
                    );

                }

            },


            complete: function () {

                button
                    .prop('disabled', false)
                    .text('Update');

            }

        });

    });


    $(document).on(
        'click',
        '.view-main-status-logs-btn',
        function () {

            const semiId =
                $(this).attr('data-semi-id');

            const name =
                $(this).attr('data-name') || '';


            console.log(
                'MAIN STATUS LOG REQUEST:',
                {
                    semi_id: semiId,
                    name: name
                }
            );


            $('#aolLogsTableBody').html(`

                <tr>

                    <td
                        colspan="5"
                        class="text-center"
                    >
                        Loading...
                    </td>

                </tr>

            `);


            $('#aolLogsModalLabel').text(
                'Main Status Logs' +
                (name ? ' - ' + name : '')
            );

            const modalElement =
                document.getElementById(
                    'aolLogsModal'
                );

            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    modalElement
                );

            modal.show();


            $.ajax({

                url: "{{ route('fund.status.logs') }}",

                type: "POST",

                dataType: "json",

                data: {

                    _token: csrfToken,

                    semi_id: semiId

                },


                success: function (response) {

                    console.log(
                        'MAIN STATUS LOG RESPONSE:',
                        response
                    );


                    const logs =
                        Array.isArray(response.logs)
                            ? response.logs
                            : [];


                    let html = '';


                    if (logs.length > 0) {

                        $.each(
                            logs,
                            function (index, log) {

                                html += `

                                    <tr>

                                        <td>
                                            ${escapeHtml(
                                                log.num ??
                                                log.id ??
                                                (index + 1)
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.new_status ??
                                                log.status ??
                                                log.fund_status ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.remarks ??
                                                log.stage_remarks ??
                                                log.fund_remarks ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.changed_by ??
                                                log.updated_by ??
                                                log.created_name ??
                                                log.name ??
                                                ''
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                log.changed_at ??
                                                log.action_datetime ??
                                                log.created_date ??
                                                log.created_at ??
                                                ''
                                            )}
                                        </td>

                                    </tr>

                                `;

                            }
                        );

                    } else {

                        html = `

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-danger"
                                >
                                    No Main Status Logs Found
                                </td>

                            </tr>

                        `;

                    }


                    $('#aolLogsTableBody')
                        .html(html);

                },


                error: function (xhr) {

                    console.error(
                        'MAIN STATUS LOG ERROR:',
                        xhr.status,
                        xhr.responseText
                    );


                    let message =
                        'Failed to load Main Status Logs.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    $('#aolLogsTableBody').html(`

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-danger"
                            >
                                ${escapeHtml(message)}
                            </td>

                        </tr>

                    `);

                }

            });

        }
    );


    /* ============================================================
       NOTES MODAL
    ============================================================ */

    $(document).on(
        'click',
        '.open-notes-modal',
        function () {

            const fileNo =
                $(this).data('file-no');


            $('#note_id').val(fileNo);

            $('#newNote').val('');


            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById(
                        'notesModal'
                    )
                );

            modal.show();


            loadDropNotes(fileNo);

        }
    );


    /* ============================================================
       LOAD DROP NOTES
    ============================================================ */

    function loadDropNotes(mainId) {

        const tbody =
            $('#notesTableBody');


        tbody.html(`

            <tr>

                <td
                    colspan="4"
                    class="text-center"
                >
                    Loading...
                </td>

            </tr>

        `);


        $.ajax({

            url: "{{ route('drop.notes') }}",

            type: "POST",

            dataType: "json",

            data: {

                _token: csrfToken,

                main_id: mainId

            },


            success: function (response) {

                console.log(
                    'NOTES RESPONSE:',
                    response
                );


                tbody.empty();


                if (
                    !response.success ||
                    !Array.isArray(response.notes) ||
                    response.notes.length === 0
                ) {

                    tbody.html(`

                        <tr>

                            <td
                                colspan="4"
                                class="text-center"
                            >
                                No notes found.
                            </td>

                        </tr>

                    `);

                    return;

                }


                $.each(
                    response.notes,
                    function (index, note) {

                        tbody.append(`

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        note.id ?? ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        note.notes_remarks ??
                                        note.remarks ??
                                        ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        note.created_name ??
                                        note.updated_by ??
                                        note.name ??
                                        ''
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        note.created_datetime ??
                                        note.action_datetime ??
                                        note.created_at ??
                                        ''
                                    )}
                                </td>

                            </tr>

                        `);

                    }
                );

            },


            error: function (xhr) {

                console.error(
                    'Notes error:',
                    xhr.status,
                    xhr.responseText
                );


                let message =
                    'Error loading notes.';


                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {

                    message =
                        xhr.responseJSON.message;

                }


                tbody.html(`

                    <tr>

                        <td
                            colspan="4"
                            class="text-center text-danger"
                        >
                            ${escapeHtml(message)}
                        </td>

                    </tr>

                `);

            }

        });

    }


    /* ============================================================
       ADD NOTE
    ============================================================ */

    $(document).on(
        'submit',
        '#addNotesForm',
        function (e) {

            e.preventDefault();


            const form =
                $(this);


            const button =
                form.find(
                    'button[type="submit"]'
                );


            const noteId =
                $('#note_id').val();


            const newNote =
                $('#newNote')
                    .val()
                    .trim();


            if (!noteId) {

                alert(
                    'Invalid student ID.'
                );

                return;

            }


            if (!newNote) {

                alert(
                    'Please enter remarks.'
                );

                $('#newNote').focus();

                return;

            }


            button
                .prop('disabled', true)
                .text('Saving...');


            $.ajax({

                url: "{{ route('drop.add-note') }}",

                type: "POST",

                dataType: "json",

                data: {

                    _token: csrfToken,

                    note_id: noteId,

                    newNote: newNote

                },


                success: function (response) {

                    console.log(
                        'ADD NOTE RESPONSE:',
                        response
                    );


                    if (response.success) {

                        alert(
                            response.message ||
                            'Note added successfully.'
                        );


                        $('#newNote').val('');


                        loadDropNotes(noteId);

                    } else {

                        alert(
                            response.message ||
                            'Unable to save note.'
                        );

                    }

                },


                error: function (xhr) {

                    console.error(
                        'ADD NOTE ERROR:',
                        xhr.status,
                        xhr.responseText
                    );


                    let message =
                        'Error saving note.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    alert(message);

                },


                complete: function () {

                    button
                        .prop('disabled', false)
                        .text('Save Note');

                }

            });

        }
    );


    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }


        return $('<div>')
            .text(value)
            .html();

    }

});

</script>

@endpush