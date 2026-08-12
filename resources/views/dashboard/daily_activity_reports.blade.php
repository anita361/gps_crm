@extends('layouts.app')

@section('title', 'Daily Activity Reports')

@section('content')

    <style>
        /* =========================================================
                   DAILY ACTIVITY REPORT
                   ========================================================= */

        .daily-report-wrapper {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 30px;
        }

        .daily-report-card {
            width: 100%;
            background: #fff;
            border: 1px solid #d5d5d5;
            border-radius: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
            overflow: hidden;
        }

        /* =========================================================
                   BLUE PAGE TITLE
                   ========================================================= */

        .daily-report-header {
            background: #2f64e7;
            color: #fff;
            text-align: center;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
        }

        .daily-report-header i {
            margin-right: 5px;
        }

        /* =========================================================
                   FILTER SECTION
                   ========================================================= */

        .filter-section {
            background: #fff;
            padding: 6px 8px 8px 8px;
            border-bottom: 1px solid #ccc;
        }

        .filter-section label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 2px;
            color: #333;
        }

        .filter-section .form-control,
        .filter-section .form-select {
            height: 23px;
            min-height: 23px;
            padding: 1px 5px;
            font-size: 10px;
            border: 1px solid #bbb;
            border-radius: 0;
        }

        .filter-section .btn {
            height: 23px;
            min-height: 23px;
            padding: 1px 12px;
            font-size: 10px;
            border-radius: 0;
        }

        .filter-button-wrapper {
            padding-top: 15px;
        }

        /* =========================================================
                   TABLE
                   ========================================================= */

        .report-table-wrapper {
            width: 100%;
            overflow-x: auto;
            padding: 5px;
        }

        .daily-report-table {
            width: 100% !important;
            min-width: 1200px;
            margin: 0 !important;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .daily-report-table thead th {
            background: #000 !important;
            color: #fff !important;
            border: 1px solid #777 !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 2px !important;
            white-space: nowrap;
            height: 20px;
        }

        .daily-report-table tbody td {
            border: 1px solid #bdbdbd !important;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
            padding: 2px 3px !important;
            height: 19px;
            white-space: nowrap;
            line-height: 14px;
        }

        .daily-report-table tbody tr:nth-child(even) {
            background: #f3f3f3;
        }

        .daily-report-table tbody tr:nth-child(odd) {
            background: #fff;
        }

        .daily-report-table tbody td:first-child {
            text-align: left;
            padding-left: 5px !important;
        }

        /* =========================================================
                   COUNT LINKS
                   ========================================================= */

        .count-link {
            color: #337ab7 !important;
            text-decoration: underline !important;
            font-weight: 600;
            font-size: 10px;
        }

        .count-link:hover {
            color: #0d6efd !important;
        }

        /* =========================================================
                   TOTAL ROW
                   ========================================================= */

        .total-row td {
            background: #eeeeee !important;
            font-weight: bold !important;
        }

        .total-row .count-link {
            font-weight: bold;
        }

        /* =========================================================
                   EMPTY
                   ========================================================= */

        .no-records {
            text-align: center !important;
            padding: 10px !important;
            font-size: 11px !important;
        }

        /* =========================================================
                   REPORT INFO
                   ========================================================= */

        .report-info {
            padding: 4px 8px;
            font-size: 10px;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        /* =========================================================
                   MOBILE
                   ========================================================= */

        @media (max-width: 768px) {

            .daily-report-header {
                font-size: 13px;
            }

            .filter-button-wrapper {
                padding-top: 0;
            }

            .report-table-wrapper {
                padding: 3px;
            }

            .daily-report-table {
                min-width: 1200px;
            }
        }
    </style>

    <div class="daily-report-wrapper">


        <div class="daily-report-card">

            {{-- =====================================================
     PAGE HEADER
     ====================================================== --}}
            <div class="daily-report-header">
                <i class="fa fa-calendar-day"></i>
                Daily Activity Reports
            </div>


            {{-- =====================================================
     FILTERS
     ====================================================== --}}
            <div class="filter-section">

                <form method="GET" action="{{ route('daily.activity.reports') }}">

                    <div class="row g-1 align-items-end">

                        {{-- FROM DATE --}}
                        <div class="col-lg-2 col-md-3 col-sm-6">

                            <label for="GetFltDatestart">
                                Leads From Date
                            </label>

                            <input type="date" class="form-control" name="GetFltDatestart" id="GetFltDatestart"
                                value="{{ $GetFltDatestart ?? request('GetFltDatestart') }}">

                        </div>


                        {{-- TO DATE --}}
                        <div class="col-lg-2 col-md-3 col-sm-6">

                            <label for="GetFltDateend">
                                Leads To Date
                            </label>

                            <input type="date" class="form-control" name="GetFltDateend" id="GetFltDateend"
                                value="{{ $GetFltDateend ?? request('GetFltDateend') }}">

                        </div>


                        {{-- PROVINCE --}}
                        <div class="col-lg-2 col-md-3 col-sm-6">

                            <label for="provinceFilter">
                                Province
                            </label>

                            @php
                                /*
                                 * Laravel conversion of:
                                 *
                                 * $con->query("SELECT DISTINCT province_name
 * FROM seminarpre
 * WHERE province_name != ''");
                                 */
                                $provinceList = \Illuminate\Support\Facades\DB::table('seminarpre')
                                    ->whereNotNull('province_name')
                                    ->where('province_name', '!=', '')
                                    ->distinct()
                                    ->orderBy('province_name')
                                    ->pluck('province_name');

                                $selectedProvince = request('provinceFilter', request('province_name', ''));
                            @endphp

                            <select name="provinceFilter" id="provinceFilter" class="form-select">

                                <option value="">All</option>

                                @foreach ($provinceList as $province)
                                    <option value="{{ $province }}"
                                        {{ $selectedProvince == $province ? 'selected' : '' }}>
                                        {{ $province }}
                                    </option>
                                @endforeach

                            </select>

                        </div>



                       {{-- REP NAME --}}
<div class="col-sm-6 col-md-4">

    <label for="rep_name">
        Rep Name:
    </label>

    @php
        $representativeList = \Illuminate\Support\Facades\DB::table('seminarpre')
            ->whereNotNull('assign_name')
            ->where('assign_name', '!=', '')
            ->distinct()
            ->orderBy('assign_name')
            ->pluck('assign_name');

        $selectedReps = request('rep_name', []);

        if (!is_array($selectedReps)) {
            $selectedReps = [$selectedReps];
        }
    @endphp

    <div class="dropdown">

        {{-- Dropdown Button --}}
        <button type="button"
                class="form-control text-start"
                id="repDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="height:23px; padding:1px 5px; font-size:10px;">

            <span id="repDropdownText">
                @if(count($selectedReps) > 0)
                    {{ implode(', ', $selectedReps) }}
                @else
                    Select Rep Name(s)
                @endif
            </span>

        </button>

        {{-- Dropdown Menu --}}
        <div class="dropdown-menu w-100 p-2"
             aria-labelledby="repDropdown"
             style="max-height:250px; overflow-y:auto; font-size:10px;">

            {{-- SEARCH --}}
            <div class="mb-2">
                <input type="text"
                       id="repSearch"
                       class="form-control"
                       placeholder="Search Rep Name..."
                       autocomplete="off"
                       style="height:25px; font-size:10px;">
            </div>

            {{-- SELECT ALL --}}
            <div class="form-check mb-1">
                <input class="form-check-input"
                       type="checkbox"
                       id="selectAllReps">

                <label class="form-check-label" for="selectAllReps">
                    <strong>Select All</strong>
                </label>
            </div>

            <hr class="my-1">

            {{-- Branch Manager --}}
            <div class="form-check rep-item">

                <input class="form-check-input rep-checkbox"
                       type="checkbox"
                       name="rep_name[]"
                       value="Branch Manager"
                       id="rep_branch_manager"
                       {{ in_array('Branch Manager', $selectedReps) ? 'checked' : '' }}>

                <label class="form-check-label" for="rep_branch_manager">
                    Branch Manager
                </label>

            </div>

            {{-- Other Representatives --}}
            @foreach ($representativeList as $rep)

                @if ($rep != 'Branch Manager')

                    <div class="form-check rep-item">

                        <input class="form-check-input rep-checkbox"
                               type="checkbox"
                               name="rep_name[]"
                               value="{{ $rep }}"
                               id="rep_{{ md5($rep) }}"
                               {{ in_array($rep, $selectedReps) ? 'checked' : '' }}>

                        <label class="form-check-label"
                               for="rep_{{ md5($rep) }}">
                            {{ $rep }}
                        </label>

                    </div>

                @endif

            @endforeach

        </div>

    </div>

</div>

                        {{-- SEARCH --}}
                        <div class="col-lg-1 col-md-2 col-sm-6">

                            <div class="filter-button-wrapper">

                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>

                            </div>

                        </div>


                        {{-- RESET --}}
                        <div class="col-lg-1 col-md-2 col-sm-6">

                            <div class="filter-button-wrapper">

                                <a href="{{ route('daily.activity.reports') }}" class="btn btn-secondary">
                                    Reset
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>



            @if (
                !empty($GetFltDatestart ?? request('GetFltDatestart')) ||
                    !empty($GetFltDateend ?? request('GetFltDateend')) ||
                    !empty(request('provinceFilter')) ||
                    !empty(request('repFilter')))

                <div class="report-info">

                    <i class="fa fa-filter"></i>

                    Showing filtered report

                    @if (!empty($GetFltDatestart ?? request('GetFltDatestart')))
                        |
                        From:
                        <strong>
                            {{ $GetFltDatestart ?? request('GetFltDatestart') }}
                        </strong>
                    @endif

                    @if (!empty($GetFltDateend ?? request('GetFltDateend')))
                        |
                        To:
                        <strong>
                            {{ $GetFltDateend ?? request('GetFltDateend') }}
                        </strong>
                    @endif

                    @if (!empty(request('provinceFilter')))
                        |
                        Province:
                        <strong>
                            {{ request('provinceFilter') }}
                        </strong>
                    @endif

                    @if (!empty(request('repFilter')))
                        |
                        Rep:
                        <strong>
                            {{ request('repFilter') }}
                        </strong>
                    @endif

                </div>

            @endif



            <div class="report-table-wrapper">

                <table class="table table-bordered table-striped daily-report-table">

                    <thead>

                        <tr>

                            <th style="width: 22%;">
                                Rep Name
                            </th>

                            <th>
                                Enrolled
                            </th>

                            <th>
                                Re-enrolled
                            </th>

                            <th>
                                Appointment Booked
                            </th>

                            <th>
                                Call Follow-Up
                            </th>

                            <th>
                                Not Answered
                            </th>

                            <th>
                                Not Interested
                            </th>

                            <th>
                                Not Eligible
                            </th>

                            <th>
                                Pending Action
                            </th>

                            <th>
                                Total
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($students ?? [] as $row)
                            @php
                                $isTotal = ($row->Rep_Name ?? '') === 'Total';

                                $fromDate = $GetFltDatestart ?? request('GetFltDatestart', '');
                                $toDate = $GetFltDateend ?? request('GetFltDateend', '');

                                $province = request('provinceFilter', '');

                                /*
                                 * IMPORTANT:
                                 * Your filter uses rep_name[]
                                 * NOT repFilter
                                 */
                                $selectedReps = request('rep_name', []);

                                if (!is_array($selectedReps)) {
                                    $selectedReps = [$selectedReps];
                                }

                                $selectedReps = array_values(array_filter($selectedReps));
                            @endphp


                            <tr class="{{ $isTotal ? 'total-row' : '' }}">


                                {{-- REP NAME --}}
                                <td>
                                    {{ $row->Rep_Name }}
                                </td>


                                {{-- ENROLLED --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'enrolled',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Enrolled ?? 0 }}

                                    </a>

                                </td>


                                {{-- RE-ENROLLED --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Re-enrolled',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Re_enrolled ?? 0 }}

                                    </a>

                                </td>


                                {{-- APPOINTMENT BOOKED --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Appointment Booked',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Appointment_Booked ?? 0 }}

                                    </a>

                                </td>


                                {{-- CALL FOLLOW-UP --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Call Follow-Up',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Call_Follow_Up ?? 0 }}

                                    </a>

                                </td>


                                {{-- NOT ANSWERED --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Not Answered',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Not_Answered ?? 0 }}

                                    </a>

                                </td>


                                {{-- NOT INTERESTED --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Not Interested',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Not_Interested ?? 0 }}

                                    </a>

                                </td>


                                {{-- NOT ELIGIBLE --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Not Eligible',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Not_Eligible ?? 0 }}

                                    </a>

                                </td>


                                {{-- PENDING ACTION --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'Pending',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Pending_Action ?? 0 }}

                                    </a>

                                </td>


                                {{-- TOTAL --}}
                                <td>

                                    <a class="count-link"
                                        href="{{ route('daily.activity.report.download', [
                                            'rep_name' => $row->Rep_Name,
                                            'status' => 'total',
                                            'GetFltDatestart' => $fromDate,
                                            'GetFltDateend' => $toDate,
                                            'provinceFilter' => $province,
                                            'rep_name_filter' => $selectedReps,
                                        ]) }}">

                                        {{ $row->Total_Count ?? 0 }}

                                    </a>

                                </td>


                            </tr>


                        @empty

                            <tr>

                                <td colspan="10" class="no-records">

                                    <i class="fa fa-info-circle"></i>

                                    No records found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const checkboxes = document.querySelectorAll('.rep-checkbox');
        const dropdownText = document.getElementById('repDropdownText');
        const searchInput = document.getElementById('repSearch');
        const selectAll = document.getElementById('selectAllReps');


        // ==============================
        // UPDATE SELECTED REP TEXT
        // ==============================
        function updateRepText() {

            let selected = [];

            checkboxes.forEach(function(checkbox) {

                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }

            });

            if (selected.length === 0) {

                dropdownText.textContent = 'Select Rep Name(s)';

            } else if (selected.length <= 2) {

                dropdownText.textContent = selected.join(', ');

            } else {

                dropdownText.textContent =
                    selected.length + ' Rep(s) Selected';

            }

            updateSelectAll();
        }


        // ==============================
        // CHECKBOX CHANGE
        // ==============================
        checkboxes.forEach(function(checkbox) {

            checkbox.addEventListener('change', function() {

                updateRepText();

            });

        });


        // ==============================
        // SEARCH REP NAME
        // ==============================
        if (searchInput) {

            searchInput.addEventListener('keyup', function() {

                let searchValue = this.value.toLowerCase().trim();

                document.querySelectorAll('.rep-item').forEach(function(item) {

                    let label = item.querySelector('label');

                    if (!label) {
                        return;
                    }

                    let repName = label.textContent
                        .toLowerCase()
                        .trim();

                    if (repName.includes(searchValue)) {

                        item.style.display = '';

                    } else {

                        item.style.display = 'none';

                    }

                });

                updateSelectAll();

            });

        }


        // ==============================
        // SELECT ALL
        // ==============================
        if (selectAll) {

            selectAll.addEventListener('change', function() {

                let checked = this.checked;

                document.querySelectorAll('.rep-item').forEach(function(item) {

                    // Only select filtered/visible representatives
                    if (item.style.display !== 'none') {

                        let checkbox =
                            item.querySelector('.rep-checkbox');

                        if (checkbox) {
                            checkbox.checked = checked;
                        }

                    }

                });

                updateRepText();

            });

        }


        // ==============================
        // UPDATE SELECT ALL STATUS
        // ==============================
        function updateSelectAll() {

            if (!selectAll) {
                return;
            }

            let visibleCheckboxes = [];

            document.querySelectorAll('.rep-item').forEach(function(item) {

                if (item.style.display !== 'none') {

                    let checkbox =
                        item.querySelector('.rep-checkbox');

                    if (checkbox) {
                        visibleCheckboxes.push(checkbox);
                    }

                }

            });


            if (visibleCheckboxes.length === 0) {

                selectAll.checked = false;

                return;
            }


            selectAll.checked = visibleCheckboxes.every(function(checkbox) {

                return checkbox.checked;

            });

        }


        // ==============================
        // INITIAL LOAD
        // ==============================
        updateRepText();

    });
</script>
@endsection
