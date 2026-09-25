@extends('layouts.app')

@section('title', 'Tution Fee Update')

@section('content')

    <style>
        .crm-Lead-Summary {
            margin-top: 105px;
        }

        .manage_file h2 {
            background: #4a4a4a;
            color: white;
            padding: 12px;
            font-size: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #opr_table thead th {
            background: #4a4a4a;
            color: white;
            font-size: 13px;
            white-space: nowrap;
        }

        #opr_table tbody td {
            font-size: 13px;
            white-space: nowrap;
            vertical-align: middle;
        }

        .fee-input {
            max-width: 140px;
        }

        .flash-ok {
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .3) inset;
        }

        .flash-error {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, .3) inset;
        }

        .pagination-wrapper {
            padding: 10px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pagination-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination-links a,
        .pagination-links span {
            padding: 8px 12px;
            margin: 2px;
            border: 1px solid #007bff;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination-links a {
            color: #007bff;
        }

        .pagination-links .active-page {
            background-color: #007bff;
            color: white;
        }

        .pagination-links .dots {
            border: none;
            color: #999;
        }
    </style>

    <section class="crm-Lead-Summary">
        <div class="container-fluid">
            <div class="manage_file">

                <h2>
                    <i class="fa fa-money-bill"></i>
                    Tution Fee Update
                </h2>

                <div class="col-12" style="padding-bottom: 25px;">

                    {{-- FILTER FORM --}}
                    <form method="GET" action="{{ route('tuition.fee.update') }}" class="row g-2 mb-3" id="filterForm">

                        {{-- Province --}}
                        <div class="col-sm-2">
                            <select name="province" id="provinceFilter" class="form-select form-control">
                                <option value="">All Provinces</option>

                                @foreach ($provinces as $province)
                                    <option value="{{ $province }}"
                                        {{ $filterProvince === $province ? 'selected' : '' }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- College --}}
                        <div class="col-sm-2">
                            <select name="clg_name" id="collegeFilter" class="form-select form-control">
                                <option value="">All Colleges</option>

                                @foreach ($colleges as $college)
                                    <option value="{{ $college }}" {{ $filterCollege === $college ? 'selected' : '' }}>
                                        {{ $college }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Campus --}}
                        <div class="col-sm-2">
                            <select name="campus_name" id="campusFilter" class="form-select form-control">
                                <option value="">All Campuses</option>

                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus }}" {{ $filterCampus === $campus ? 'selected' : '' }}>
                                        {{ $campus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Program --}}
                        <div class="col-sm-2">
                            <select name="prg_name" id="programFilter" class="form-select form-control">
                                <option value="">All Programs</option>

                                @foreach ($programs as $program)
                                    <option value="{{ $program }}"
                                        {{ $filterProgram === $program ? 'selected' : '' }}>
                                        {{ $program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Page limit --}}
                        <input type="hidden" name="limit" value="{{ $limit }}" id="filterLimit">

                        {{-- Clear --}}
                        <div class="col-sm-2">
                            <a href="{{ route('tuition.fee.update') }}" class="btn btn-secondary">
                                Clear Filters
                            </a>
                        </div>

                    </form>

                </div>

                <div class="col-sm-12">

                    {{-- Page Limit --}}
                    <select id="limitSelect" class="form-select form-select-sm"
                        style="width:auto; display:inline-block; margin-bottom:10px;">
                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $limit == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
                    </select>

                    <div class="table-responsive">

                        <table id="opr_table" class="table file-table1 responsive table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Province</th>
                                    <th>College</th>
                                    <th>Campus</th>
                                    <th>Program</th>
                                    <th>Tution Fee</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($collegeList as $row)
                                    <tr id="row-{{ $row->id }}">

                                        <td>{{ $row->province }}</td>

                                        <td>{{ $row->clg_name }}</td>

                                        <td>{{ $row->campus_name }}</td>

                                        <td>{{ $row->prg_name }}</td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm fee-input"
                                                value="{{ $row->tution_fee }}" data-id="{{ $row->id }}">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary save-fee"
                                                data-id="{{ $row->id }}">
                                                Save
                                            </button>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="text-center" style="padding:20px;">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>

                    {{-- Pagination --}}
                    <div class="pagination-wrapper">

                        <div>
                            @if ($collegeList->total() > 0)
                                <p>
                                    Showing
                                    {{ $collegeList->firstItem() }}
                                    to
                                    {{ $collegeList->lastItem() }}
                                    of
                                    {{ $collegeList->total() }}
                                    entries
                                </p>
                            @else
                                <p>Showing 0 to 0 of 0 entries</p>
                            @endif
                        </div>

                        <div class="pagination-links">

                            @if ($collegeList->onFirstPage())
                                <span style="color:#999;">« Prev</span>
                            @else
                                <a href="{{ $collegeList->previousPageUrl() }}">
                                    « Prev
                                </a>
                            @endif

                            @php
                                $currentPage = $collegeList->currentPage();
                                $lastPage = $collegeList->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($currentPage + 2, $lastPage);
                            @endphp

                            @if ($startPage > 1)

                                <a href="{{ $collegeList->url(1) }}">1</a>

                                @if ($startPage > 2)
                                    <span class="dots">...</span>
                                @endif

                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                @if ($i == $currentPage)
                                    <span class="active-page">{{ $i }}</span>
                                @else
                                    <a href="{{ $collegeList->url($i) }}">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            @if ($endPage < $lastPage)

                                @if ($endPage < $lastPage - 1)
                                    <span class="dots">...</span>
                                @endif

                                <a href="{{ $collegeList->url($lastPage) }}">
                                    {{ $lastPage }}
                                </a>

                            @endif

                            @if ($collegeList->hasMorePages())
                                <a href="{{ $collegeList->nextPageUrl() }}">
                                    Next »
                                </a>
                            @else
                                <span style="color:#999;">Next »</span>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {



            const filterForm = document.getElementById('filterForm');

            const provinceFilter = document.getElementById('provinceFilter');
            const collegeFilter = document.getElementById('collegeFilter');
            const campusFilter = document.getElementById('campusFilter');
            const programFilter = document.getElementById('programFilter');

            const limitSelect = document.getElementById('limitSelect');
            const limitInput = document.getElementById('filterLimit');


            function submitFilter() {

                if (!filterForm) {
                    return;
                }

                if (limitSelect && limitInput) {
                    limitInput.value = limitSelect.value;
                }

                filterForm.submit();
            }




            if (provinceFilter) {
                provinceFilter.addEventListener('change', submitFilter);
            }

            if (collegeFilter) {
                collegeFilter.addEventListener('change', submitFilter);
            }

            if (campusFilter) {
                campusFilter.addEventListener('change', submitFilter);
            }

            if (programFilter) {
                programFilter.addEventListener('change', submitFilter);
            }

            if (limitSelect) {
                limitSelect.addEventListener('change', submitFilter);
            }



            document.addEventListener('click', async function(e) {

                if (!e.target.classList.contains('save-fee')) {
                    return;
                }

                const id = e.target.getAttribute('data-id');

                const input = document.querySelector(
                    '.fee-input[data-id="' + id + '"]'
                );

                if (input) {
                    await saveFee(id, input);
                }
            });




            document.addEventListener('keydown', async function(e) {

                if (
                    e.target.classList.contains('fee-input') &&
                    e.key === 'Enter'
                ) {

                    e.preventDefault();

                    const id = e.target.getAttribute('data-id');

                    await saveFee(id, e.target);
                }
            });




            async function saveFee(id, inputEl) {

                let fee = (inputEl.value || '').trim();

                // Remove commas
                let cleaned = fee.replace(/,/g, '');


                if (!/^\d+(\.\d{1,2})?$/.test(cleaned)) {

                    flash(
                        inputEl,
                        false,
                        'Invalid amount. Use numbers like 12000 or 12000.50'
                    );

                    return;
                }

                try {

                    const response = await fetch(
                        "{{ route('tuition.fee.update.save') }}", {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',

                                'X-CSRF-TOKEN': "{{ csrf_token() }}",

                                'Accept': 'application/json'
                            },

                            body: new URLSearchParams({
                                id: id,
                                tution_fee: cleaned
                            })
                        }
                    );

                    const data = await response.json();

                    if (data.status === true) {

                        inputEl.value =
                            data.tution_fee ?? cleaned;

                        flash(
                            inputEl,
                            true,
                            data.message ||
                            'Tuition fee updated successfully.'
                        );

                    } else {

                        flash(
                            inputEl,
                            false,
                            data.message || 'Update failed.'
                        );
                    }

                } catch (error) {

                    console.error(
                        'Tuition Fee Update Error:',
                        error
                    );

                    flash(
                        inputEl,
                        false,
                        'Something went wrong while updating the tuition fee.'
                    );
                }
            }



            function flash(el, ok, msg) {

                el.classList.remove(
                    'flash-ok',
                    'flash-error'
                );

                el.classList.add(
                    ok ? 'flash-ok' : 'flash-error'
                );

                if (msg) {
                    alert(msg);
                }

                setTimeout(function() {

                    el.classList.remove(
                        'flash-ok',
                        'flash-error'
                    );

                }, 1200);
            }

        });
    </script>

@endsection
