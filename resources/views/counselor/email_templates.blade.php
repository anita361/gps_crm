@extends('layouts.app')

@section('title', 'Email Templates')

@section('content')

<div class="container-fluid main-crm" style="margin-top:100px;">

    <div class="manage_file">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2>Template Listing</h2>

            <a href="{{ route('counselor.email.template.create') }}"
               class="btn btn-sm btn-success">
                Add New Templates
            </a>

        </div>

        <div class="card shadow">

            <div class="card-body">

                <div class="table-responsive">

                    <table id="appointment_data"
                           class="table file-table1 responsive table-striped"
                           width="100%">

                        <thead>
                            <tr>

                                <th style="white-space: nowrap;">
                                    Sr
                                </th>

                                <th style="white-space: nowrap;">
                                    Templates Name
                                </th>

                                <th style="white-space: nowrap;">
                                    Templates
                                </th>

                                <th style="white-space: nowrap;">
                                    Created By
                                </th>

                                <th style="white-space: nowrap;">
                                    Created Date
                                </th>

                                <th style="white-space: nowrap;">
                                    File Name
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @forelse($templates as $key => $template)

                                <tr>

                                    <td style="white-space: nowrap;">
                                        {{ $templates->firstItem() + $key }}
                                    </td>

                                    <td style="white-space: nowrap;">
                                        {{ $template->temp_name }}
                                    </td>

                                    <td>
                                        {!! html_entity_decode($template->templates) !!}
                                    </td>

                                    <td style="white-space: nowrap;">
                                        {{ $template->created_by }}
                                    </td>

                                    <td style="white-space: nowrap;">
                                        {{ $template->created_date }}
                                    </td>

                                    <td style="white-space: nowrap;">
                                        {{ $template->file_name }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">
                                        No result found!!!
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $templates->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection