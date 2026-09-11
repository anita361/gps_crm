<div class="modal-header bg-primary text-white">

    <h5 class="modal-title">
        <i class="fa fa-phone"></i> Call Logs
    </h5>

    <button type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>Call Time</th>
                    <th>Status</th>
                    <th>Followup / Enrolled / Drop Date</th>
                    <th>Remarks</th>
                    <th>Counsellor Name</th>
                </tr>
            </thead>

            <tbody>

                @forelse($logs as $log)

                    <tr>

                        <td>
                            {{ $log->created_date ?? '-' }}
                            {{ $log->created_time ?? '' }}
                        </td>

                        <td>
                            {{ $log->status_counsalar ?? '-' }}
                        </td>

                        <td>
                            {{ $log->follow_date ?? '-' }}
                            {{ $log->follow_time ?? '' }}
                        </td>

                        <td>
                            {{ $log->remark ?? '-' }}
                        </td>

                        <td>
                            {{ $log->counslor_name ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            No Call Logs Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <hr>

    <h5 class="bg-dark text-white text-center p-2">
        Notes
    </h5>

    <div class="table-responsive">

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>
                    <th width="80">S.No</th>
                    <th>Remarks</th>
                    <th>Updated By</th>
                    <th>Action Date Time</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        {{ $lead->sno }}
                    </td>

                    <td>
                        {{ $lead->notes ?? '-' }}
                    </td>

                    <td>
                        {{ $lead->assign_name ?? '-' }}
                    </td>

                    <td>
                        {{ $lead->updated_at ?? '-' }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

<div class="modal-footer">

    <button type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">

        Close

    </button>

</div>