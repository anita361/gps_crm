@extends('layouts.app')
@section('title', 'Manage Files')
@section('content')
    @if (in_array($sessRole, ['branch_manager', 'counselor']))
        <section class="linkidtainer-fluid">
            <div class="container-fluid main-crm">
                <div class="manage_file">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2> <i class="fa fa-file"></i> Manage Files </h2>
                        @if (request()->filled('search_value'))
                            <a href="{{ route('manage.files') }}" class="btn btn-secondary"> <i class="fa fa-refresh"></i>
                                Reset Search </a>
                        @endif
                    </div>
                    @if (request()->filled('search_value'))
                        <div class="alert alert-info mb-3"> <i class="fa fa-search"></i> <strong>Search:</strong>
                            {{ ucfirst(str_replace('_', ' ', request('search_type'))) }} = <strong>
                                {{ request('search_value') }} </strong> <span class="ms-2"> | {{ $masterFiles->count() }}
                                record(s) found </span> </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="tablePagination" class="table table-striped table-hover file-table1" cellspacing="4"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Relative Name</th>
                                        <th>Relation</th>
                                        <th>Client Number</th>
                                        <th>Counselor</th>
                                        <th>Status</th>
                                        <th>Category</th>
                                        <th>Country</th>
                                        <th>Edit</th>
                                        <th>Action</th>
                                        <th>Logs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($masterFiles as $file)
                                        @php
                                            $relativeName = '';
                                            $relation = '';
                                            if (!empty($file->fathers_name)) {
                                                $relativeName = $file->fathers_name;
                                                $relation = 'father';
                                            } elseif (!empty($file->husband_name)) {
                                                $relativeName = $file->husband_name;
                                                $relation = 'husband';
                                            } elseif (!empty($file->wife_name)) {
                                                $relativeName = $file->wife_name;
                                                $relation = 'wife';
                                            }
                                            $leadAssignId = (int) ($file->lead_assign_id ?? 0);
                                            $currentOwnerId = (int) $sessionId;
                                            $isCurrentOwner = $leadAssignId > 0 && $leadAssignId === $currentOwnerId;
                                            $leadId = (int) ($file->lead_id ?? 0);
                                            $logId = (int) ($file->legacy_seminar_id ?? 0);
                                            /* | Keep semi_id available if an actual seminarpre | record exists. */ $semiId =
                                                (int) ($file->semi_id ?? 0);
                                            $mobile = $file->smobile ?? ($file->callerno ?? '');
                                            $clientName = $file->sname ?? ($file->applicant_name ?? '-');
                                            $counselorName = $file->lead_assign_name ?? ($file->assign_name ?? '-');
                                        @endphp <tr> {{-- SR NO --}} <td> {{ $loop->iteration }} </td>
                                            {{-- NAME --}} <td> {{ $clientName }} </td> {{-- RELATIVE NAME --}}
                                            <td> {{ $relativeName ?: '-' }} </td> {{-- RELATION --}} <td>
                                                {{ $relation ?: '-' }} </td> {{-- CLIENT NUMBER --}} <td>
                                                {{ $mobile ?: '-' }} </td> {{-- COUNSELOR --}} <td>
                                                {{ $counselorName }} </td> {{-- STATUS --}} <td>
                                                {{ $file->student_status ?? '-' }} </td> {{-- CATEGORY --}} <td>
                                                {{ $file->category ?? '-' }} </td> {{-- COUNTRY --}} <td>
                                                {{ $file->scountry ?? '-' }} </td>
                                            @if ($sessRole === 'counselor')
                                                @if ($isCurrentOwner && !empty($mobile))
                                                    <td> <a href="{{ route('walking-details', ['smobile' => $mobile]) }}"
                                                            class="edit-btn btn btn-sm btn-primary"> View/Edit </a>
                                                    </td>
                                                @else
                                                    <td> <a href="javascript:void(0);"
                                                            class="edit-btn btn btn-sm btn-secondary"
                                                            onclick="return false;" aria-disabled="true"> View/Edit </a>
                                                    </td>
                                                @endif
                                            @else
                                                {{-- Branch Manager can edit any file --}} <td>
                                                    @if (!empty($mobile))
                                                        <a href="{{ route('walking-details', ['smobile' => $mobile]) }}"
                                                            class="edit-btn btn btn-sm btn-primary"> View/Edit </a>
                                                    @else
                                                        <a href="javascript:void(0);"
                                                            class="edit-btn btn btn-sm btn-secondary"
                                                            onclick="return false;" aria-disabled="true"> View/Edit </a>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="transfer-status-cell" data-lead-id="{{ $leadId }}">
                                                @if ($isCurrentOwner)
                                                    <span class="badge bg-secondary"> Current Owner </span>
                                                @elseif ($leadId <= 0)
                                                    <span class="badge bg-danger"> Lead ID Missing </span>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm request-transfer-btn"
                                                        data-lead-id="{{ $leadId }}"
                                                        data-mobile="{{ $mobile }}" data-name="{{ $clientName }}"
                                                        data-current-counselor="{{ $counselorName }}"> <i
                                                            class="fa fa-exchange"></i> Request Transfer </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($logId > 0)
                                                    <button type="button" class="btn btn-info btn-sm view-logs-btn"
                                                        data-log-id="{{ $logId }}"
                                                        data-lead-id="{{ $leadId }}"
                                                        data-name="{{ $clientName }}"> <i class="fa fa-history"></i> View
                                                        Logs </button>
                                                @else
                                                    <span class="text-muted"> No ID </span>
                                                @endif
                                            </td>
                                    </tr> @empty <tr>
                                            <td colspan="12" class="text-center">
                                                @if (request()->filled('search_value'))
                                                    <div class="py-3"> <i class="fa fa-search fa-2x text-muted mb-2"></i>
                                                        <div> No records found for <strong>
                                                                "{{ request('search_value') }}" </strong> </div>
                                                        <div class="mt-2"> <a href="{{ route('manage.files') }}"
                                                                class="btn btn-sm btn-secondary"> <i
                                                                    class="fa fa-refresh"></i> Show All Files </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    No records found.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="logsModal" tabindex="-1" aria-labelledby="logsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logsModalLabel"> File Logs </h5> <button type="button"
                            class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"> <strong> Client Name: </strong> <span id="logsClientName"> - </span> </div>
                        <div id="logsLoader" class="text-center" style="display:none;">
                            <div class="spinner-border" role="status"> <span class="visually-hidden"> Loading... </span>
                            </div>
                            <div class="mt-2"> Loading logs... </div>
                        </div> {{-- STATUS LOGS --}} <h5 class="mb-2"> Status Logs </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Main ID</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Stage Date</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody id="logsTableBody">
                                    <tr>
                                        <td colspan="7" class="text-center"> No logs loaded. </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> {{-- NOTES --}} <h5 class="mt-4 mb-2"> Notes </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Main ID</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                        <th>Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody id="notesTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center"> No notes loaded. </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> {{-- TRANSFER HISTORY --}} <h5 class="mt-4 mb-2"> Transfer History </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Lead</th>
                                        <th>Mobile</th>
                                        <th>Current Counselor</th>
                                        <th>Requested By</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Rejection Reason</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody id="transferLogsTableBody">
                                    <tr>
                                        <td colspan="10" class="text-center"> No transfer history loaded. </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close </button> </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                function escapeHtml(value) {
                    const div = document.createElement('div');
                    div.textContent = value === null || value === undefined ? '' : String(value);
                    return div.innerHTML;
                }
                document.querySelectorAll('.view-logs-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const logId = parseInt(this.getAttribute('data-log-id'), 10);
                        const leadId = parseInt(this.getAttribute('data-lead-id'), 10);
                        const clientName = this.getAttribute('data-name');
                        if (!logId || logId <= 0) {
                            alert('Log ID not found.');
                            return;
                        }
                        document.getElementById('logsClientName').textContent = clientName || '-';
                        document.getElementById('logsTableBody').innerHTML =
                            ` <tr> <td colspan="7" class="text-center"> Loading... </td> </tr> `;
                        document.getElementById('notesTableBody').innerHTML =
                            ` <tr> <td colspan="4" class="text-center"> Loading... </td> </tr> `;
                        document.getElementById('transferLogsTableBody').innerHTML =
                            ` <tr> <td colspan="10" class="text-center"> Loading... </td> </tr> `;
                        const modalElement = document.getElementById('logsModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modal.show();
                        document.getElementById('logsLoader').style.display =
                            'block';
                        fetch("{{ route('manage.files.logs') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                /* | Legacy status/notes log ID */
                                semi_id: logId,
                                /* | Transfer request ID */
                                lead_id: leadId
                            })
                        }).then(function(response) {
                            return response.json().then(function(data) {
                                return {
                                    status: response.status,
                                    data: data
                                };
                            });
                        }).then(function(result) {
                            document.getElementById('logsLoader').style.display = 'none';
                            if (result.status !== 200 || result.data.error) {
                                throw new Error(result.data.error || result.data.message ||
                                    'Unable to load logs.');
                            }
                            const data = result
                                .data;
                            let logsHtml = '';
                            if (data.logs && data.logs.length > 0) {
                                data.logs.forEach(function(log) {
                                    logsHtml +=
                                        ` <tr> <td> ${escapeHtml(log.main_id ?? '')} </td> <td> ${escapeHtml(log.oprStsSend ?? '')} </td> <td> ${escapeHtml(log.stage ?? '')} </td> <td> ${escapeHtml(log.stage_date ?? '')} </td> <td> ${escapeHtml(log.stage_remarks ?? '')} </td> <td> ${escapeHtml(log.updated_by ?? '')} </td> <td> ${escapeHtml(log.created_date ?? '')} </td> </tr> `;
                                });
                            } else {
                                logsHtml =
                                    ` <tr> <td colspan="7" class="text-center"> No logs found. </td> </tr> `;
                            }
                            document.getElementById('logsTableBody').innerHTML =
                                logsHtml;
                            let notesHtml = '';
                            if (data.notes && data.notes.length > 0) {
                                data.notes.forEach(function(note) {
                                    notesHtml +=
                                        ` <tr> <td> ${escapeHtml(note.main_id ?? '')} </td> <td> ${escapeHtml(note.remarks ?? '')} </td> <td> ${escapeHtml(note.updated_by ?? '')} </td> <td> ${escapeHtml(note.datetime ?? '')} </td> </tr> `;
                                });
                            } else {
                                notesHtml =
                                    ` <tr> <td colspan="4" class="text-center"> No notes found. </td> </tr> `;
                            }
                            document.getElementById('notesTableBody').innerHTML =
                                notesHtml;
                            let transferHtml = '';
                            if (data.transfer_logs && data.transfer_logs.length > 0) {
                                data.transfer_logs.forEach(function(transfer) {
                                    transferHtml +=
                                        ` <tr> <td> ${escapeHtml(transfer.id ?? '')} </td> <td> ${escapeHtml(transfer.lead_name ?? '')} </td> <td> ${escapeHtml(transfer.lead_mobile ?? '')} </td> <td> ${escapeHtml(transfer.current_counselor_name ?? '')} </td> <td> ${escapeHtml(transfer.requested_by_name ?? '')} </td> <td> ${escapeHtml(transfer.requested_branch ?? '')} </td> <td> ${escapeHtml(transfer.status ?? '')} </td> <td> ${escapeHtml(transfer.rejection_reason ?? '')} </td> <td> ${escapeHtml(transfer.created_at ?? '')} </td> <td> ${escapeHtml(transfer.updated_at ?? '')} </td> </tr> `;
                                });
                            } else {
                                transferHtml =
                                    ` <tr> <td colspan="10" class="text-center"> No transfer history found. </td> </tr> `;
                            }
                            document.getElementById('transferLogsTableBody').innerHTML =
                                transferHtml;
                        }).catch(function(error) {
                            document.getElementById('logsLoader').style.display = 'none';
                            document.getElementById('logsTableBody').innerHTML =
                                ` <tr> <td colspan="7" class="text-center text-danger"> ${escapeHtml(error.message)} </td> </tr> `;
                            document.getElementById('notesTableBody').innerHTML =
                                ` <tr> <td colspan="4" class="text-center"> Unable to load notes. </td> </tr> `;
                            document.getElementById('transferLogsTableBody').innerHTML =
                                ` <tr> <td colspan="10" class="text-center"> Unable to load transfer history. </td> </tr> `;
                        });
                    });
                });
                document.querySelectorAll('.request-transfer-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const leadId = this.getAttribute('data-lead-id');
                        const mobile = this.getAttribute('data-mobile');
                        const name = this.getAttribute('data-name');
                        if (!leadId || parseInt(leadId, 10) <= 0) {
                            alert('Lead ID not found. Transfer cannot be requested.');
                            return;
                        }
                        const confirmation = confirm('Do you want to request transfer for ' + name +
                            ' (' + mobile + ')?');
                        if (!confirmation) {
                            return;
                        }
                        const transferButton = this;
                        transferButton.disabled = true;
                        transferButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
                        fetch("{{ route('counselor.lead.transfer.request') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                /* | IMPORTANT: | lead_appointed.id */
                                lead_id: parseInt(leadId, 10)
                            })
                        }).then(function(response) {
                            return response.json().then(function(data) {
                                return {
                                    status: response.status,
                                    data: data
                                };
                            });
                        }).then(function(result) {
                            if (result.status === 200 && result.data.status === 'success') {
                                alert(result.data.message ||
                                    'Transfer request sent successfully.');
                                transferButton.outerHTML =
                                    ` <span class="badge bg-warning text-dark"> <i class="fa fa-clock-o"></i> Transfer Requested </span> `;
                                return;
                            }
                            throw new Error(result.data.message ||
                                'Unable to send transfer request.');
                        }).catch(function(error) {
                            alert(error.message);
                            transferButton.disabled = false;
                            transferButton.innerHTML =
                                ` <i class="fa fa-exchange"></i> Request Transfer `;
                        });
                    });
                });
            });
        </script>
    @endif @endsection
