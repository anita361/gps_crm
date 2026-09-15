@extends('layouts.app')

@section('title', 'Email Templates')

@section('content')

<section class="crm-Lead-Summary linkidtainer-fluid">


<div class="container-fluid main-crm template-page">


    <!-- Top Blue Title -->
    <div class="template-top-title">
        Template Listing
    </div>



    <div class="template-container">


        <!-- Black Header -->
        <div class="template-black-bar">
            Email Templates
        </div>



        <div class="template-content-area">


            <h4>
                Template Listing
            </h4>



            <a href="{{ route('counselor.email.template.create') }}"
               class="btn btn-sm btn-success add-btn">

                Add New Templates

            </a>




            <div class="table-responsive">


                <table id="appointment_data"
                       class="template-table"
                       width="100%">



                    <thead>

                    <tr>

                        <th>
                            Sr
                        </th>


                        <th>
                            Templates name
                        </th>


                        <th>
                            Templates
                        </th>


                        <th>
                            Created By
                        </th>


                        <th>
                            Created Date
                        </th>


                        <th>
                            File Name
                        </th>


                    </tr>


                    </thead>





                    <tbody>


                    @forelse($templates as $key => $template)


                    <tr>


                        <td>
                            {{ $templates->firstItem() + $key }}
                        </td>



                        <td>
                            {{ $template->temp_name }}
                        </td>



                        <td class="template-html">

                            {!! html_entity_decode($template->templates) !!}

                        </td>




                        <td>
                            {{ $template->created_by }}
                        </td>




                        <td>
                            {{ $template->created_date }}
                        </td>




                        <td>
                            {{ $template->file_name }}
                        </td>



                    </tr>



                    @empty



                    <tr>

                        <td colspan="6" class="no-data">

                            No result found!!!

                        </td>

                    </tr>



                    @endforelse



                    </tbody>



                </table>


            </div>




            <!-- Pagination -->

            @if($templates->hasPages())

                <div class="pagination-box">

                    {{ $templates->links() }}

                </div>

            @endif




        </div>



    </div>



</div>


</section>





<style>


/* Main Page */

.template-page{

    margin-top:100px;
    background:#fff;
    min-height:900px;

}



/* Blue Header */

.template-top-title{

    height:25px;

    background:#2463e8;

    color:#fff;

    text-align:center;

    font-size:11px;

    font-weight:bold;

    line-height:25px;

}




/* Outer Box */

.template-container{

    margin:10px 15px;

    border:1px solid #ddd;

    background:#fff;

}



/* Black Line */

.template-black-bar{


    height:20px;

    background:#000;

    color:white;

    font-size:11px;

    font-weight:bold;

    padding-left:10px;

    line-height:20px;


}





/* Content */

.template-content-area{


    padding:15px 70px;


    position:relative;


}




.template-content-area h4{


    font-size:14px;

    font-weight:bold;

    margin-bottom:15px;


}





/* Button */

.add-btn{


    position:absolute;

    right:70px;

    top:10px;


}







/* Table */


/* Table */

.template-table {

    width: 70%;
    border-collapse: collapse;
    font-size: 11px;
    table-layout: fixed;   /* Important */
}


.template-table th {

    background: #000;
    color: #fff;
    border: 1px solid #000;
    padding: 6px;
    text-align: left;
}


.template-table td {

    border: 1px solid #ccc;
    padding: 6px;
    vertical-align: top;
    word-wrap: break-word;
    overflow-wrap: break-word;
}


/* Column Width */

.template-table th:nth-child(1),
.template-table td:nth-child(1) {
    width: 40px;       /* Sr */
}


.template-table th:nth-child(2),
.template-table td:nth-child(2) {
    width: 180px;      /* Template name */
}


.template-table th:nth-child(3),
.template-table td:nth-child(3) {
    width: 350px;      /* Template content */
}


.template-table th:nth-child(4),
.template-table td:nth-child(4) {
    width: 100px;      /* Created By */
}


.template-table th:nth-child(5),
.template-table td:nth-child(5) {
    width: 130px;      /* Created Date */
}


.template-table th:nth-child(6),
.template-table td:nth-child(6) {
    width: 120px;      /* File Name */
}



.template-table tbody tr:nth-child(even) {

    background:#fafafa;

}



.template-html {

    max-width:350px;
    max-height:120px;
    overflow:hidden;
    white-space:normal;
}



.no-data {

    text-align:center;
    padding:20px;

}



.pagination-box {

    margin-top:20px;

}




</style>



@endsection
