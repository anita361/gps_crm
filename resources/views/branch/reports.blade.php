@extends('layouts.app')

@section('title', 'Reports')

@section('content')

<style>
    .imgloader {
        margin: auto;
        width: 100%;
        text-align: center;
        display: none;
    }

    .imgloader img {
        width: 100px;
        margin: 20px auto;
        float: none;
    }

    .reports-section {
        margin-bottom: 20px;
    }

    .manage_file {
        background: #fff;
        padding: 0 0 20px 0;
    }

    .reports-title {
        background: #2868e8;
        color: #fff;
        text-align: center;
        padding: 7px;
        margin-bottom: 15px;
        font-size: 15px;
        font-weight: 500;
    }

    .reports-title i {
        margin-right: 5px;
    }

    .search_input {
        font-size: 12px;
        margin: 10px 0 5px 8px;
    }

    .search-button {
        background: #555;
        color: #fff;
        border: 0;
        padding: 7px 18px;
        border-radius: 4px;
        margin-top: 22px;
        cursor: pointer;
        font-size: 12px;
    }

    .search-button:hover {
        background: #333;
    }

    #alldatacount {
        width: 100%;
        margin-top: 20px;
    }

    #alldata {
        width: 100%;
    }

    .scrollToTop {
        position: fixed;
        right: 20px;
        bottom: 20px;
        display: none;
        font-size: 30px;
        color: #2868e8;
        z-index: 9999;
    }

    @media (max-width: 767px) {

        .search-button {
            margin-top: 0;
            margin-bottom: 15px;
        }

        .imgloader img {
            margin: 20px auto !important;
        }

    }
</style>

{{-- ========================================================= --}}
{{-- REPORT SEARCH SECTION --}}
{{-- ========================================================= --}}

<section class="crm-Lead-Summary reports-section">


    <div class="container-fluid main-crm">

        <div class="manage_file">

            {{-- Page Heading --}}
            <div class="reports-title">
                <i class="fa fa-desktop"></i>
                Reports
            </div>


            {{-- Search --}}
            <div class="row">

                <div class="col-sm-12 col-xs-12">

                    <p class="search_input">
                        <strong>Search By Date</strong>
                    </p>

                </div>


                {{-- From Date --}}
                <div class="col-sm-4 col-md-3 col-xs-12"
                    style="margin-bottom:20px;">

                    <input
                        type="text"
                        placeholder="From Date"
                        id="post_at"
                        name="search[post_at]"
                        value="{{ request('post_at', date('Y-m-01')) }}"
                        class="form-control"
                        autocomplete="off">

                </div>


                {{-- To Date --}}
                <div class="col-sm-4 col-md-3 col-xs-12"
                    style="margin-bottom:20px;">

                    <input
                        type="text"
                        placeholder="To Date"
                        id="post_at_to_date"
                        name="search[post_at_to_date]"
                        value="{{ request('post_at_to_date', date('Y-m-d')) }}"
                        class="form-control"
                        autocomplete="off">

                </div>


                {{-- Report Type --}}
                <div class="col-sm-4 col-md-3 col-xs-12"
                    style="margin-bottom:20px;">

                    <select
                        id="type_report"
                        name="type_report"
                        class="form-control">

                        <option value="">
                            Select Report Type
                        </option>

                        <option value="apponted">
                            Appointed Report
                        </option>

                        <option value="walkin">
                            Walkin Report
                        </option>

                        <option value="lead">
                            Lead Report
                        </option>

                    </select>

                </div>


                {{-- Search Button --}}
                <div class="col-sm-2 col-md-3 col-xs-12">

                    <button
                        type="button"
                        name="go"
                        class="search-button"
                        id="search">

                        Search

                    </button>

                </div>

            </div>


            {{-- Loader --}}
            <div
                id="imgloader"
                class="imgloader">

                <img
                    src="{{ asset('images/loader.gif') }}"
                    alt="Loading...">

            </div>


            {{-- Count Result --}}
            <div id="alldatacount"></div>

        </div>

    </div>


</section>

{{-- ========================================================= --}}
{{-- REPORT DETAILS SECTION --}}
{{-- ========================================================= --}}

<section class="crm-Lead-Summary">


    <div class="container-fluid">

        <div class="manage_file">

            <div id="autodata">

                <div id="alldata"></div>

            </div>

        </div>

    </div>


</section>

{{-- ========================================================= --}}
{{-- SCROLL TO TOP --}}
{{-- ========================================================= --}}

<a
    href="#"
    class="scrollToTop">


    <i
        class="fa fa-chevron-circle-up"
        aria-hidden="true">
    </i>


</a>

@endsection

{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

@push('scripts')

<script>
    $(document).ready(function() {


        /* =========================================================
           HIDE LOADER INITIALLY
        ========================================================= */

        $("#imgloader").hide();


        /* =========================================================
           DATEPICKER
        ========================================================= */

        if (typeof $.fn.datepicker !== 'undefined') {

            $("#post_at").datepicker({

                format: 'yyyy-mm-dd',

                autoclose: true,

                todayHighlight: true,

                orientation: 'bottom auto'

            });


            $("#post_at_to_date").datepicker({

                format: 'yyyy-mm-dd',

                autoclose: true,

                todayHighlight: true,

                orientation: 'bottom auto'

            });

        } else {

            console.error(
                'Bootstrap Datepicker is not loaded.'
            );

        }


        /* =========================================================
           SEARCH BUTTON
        ========================================================= */

        $('#search').click(function() {


            $("#imgloader").show();


            var from_date =
                $('#post_at').val();


            var to_date =
                $('#post_at_to_date').val();


            var type_report =
                $('#type_report').val();


            /* =====================================================
               VALIDATION
            ===================================================== */

            if (
                from_date != '' &&
                to_date != '' &&
                type_report != ''
            ) {


                /* =================================================
                   AJAX REQUEST
                ================================================= */

                $.ajax({

                    url: "{{ route('branch.reports.data') }}",

                    method: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        from_date: from_date,

                        to_date: to_date,

                        type_report: type_report

                    },


                    /* =============================================
                       SUCCESS
                    ============================================= */

                    success: function(response) {


                        $("#imgloader").hide();


                        /* =========================================
                           COUNT
                        ========================================= */

                        if (type_report != 'lead') {

                            $('#alldatacount')
                                .html(response.count_html);

                        } else {

                            $('#alldatacount')
                                .html('');

                        }


                        /* =========================================
                           DETAILS
                        ========================================= */

                        $('#alldata')
                            .html(response.details_html);


                        /* =========================================
                           DATATABLE
                        ========================================= */

                        if (
                            $('#appointment_data').length
                        ) {


                            /*
                             * Destroy existing DataTable
                             * if already initialized
                             */

                            if (
                                $.fn.DataTable.isDataTable(
                                    '#appointment_data'
                                )
                            ) {

                                $('#appointment_data')
                                    .DataTable()
                                    .destroy();

                            }


                            $('#appointment_data')
                                .DataTable({

                                    pageLength: 10,

                                    lengthMenu: [

                                        [10, 25, 50, 100],

                                        [10, 25, 50, 100]

                                    ],

                                    ordering: true,

                                    searching: true

                                });

                        }

                    },


                    /* =============================================
                       ERROR
                    ============================================= */

                    error: function(xhr) {

                        $("#imgloader").hide();

                        console.log("HTTP Status:", xhr.status);
                        console.log("Response:", xhr.responseText);

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;
                            let message = '';

                            $.each(errors, function(key, value) {
                                message += value[0] + "\n";
                            });

                            alert(message);

                        } else {

                            alert(
                                'Error ' + xhr.status +
                                '\n\n' +
                                (xhr.responseJSON?.message || xhr.responseText)
                            );
                        }
                    }



                });


            } else {


                $("#imgloader").hide();


                alert(
                    "Please Select All Required Fields"
                );

            }

        });


      

        setTimeout(function() {

            $('body').addClass('loaded');

        }, 1000);


       

        $(window).scroll(function() {

            if ($(this).scrollTop() > 100) {

                $('.scrollToTop').fadeIn();

            } else {

                $('.scrollToTop').fadeOut();

            }

        });


        $('.scrollToTop').click(function(e) {

            e.preventDefault();


            $('html, body').animate(

                {
                    scrollTop: 0
                },

                500

            );

        });


    });
</script>

@endpush