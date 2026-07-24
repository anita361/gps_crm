<div class="modal-header">
    <h4 class="modal-title">
        <i class="fa fa-phone"></i> Call Logs
    </h4>

    <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <div class="table-responsive">

        <table class="table table-bordered">

            <thead class="table-dark">

            <tr>

                <th>Call Time</th>

                <th>Status</th>

                <th>Followup / Enrolled / Drop Date</th>

                <th>Remarks</th>

                <th>Counselor Name</th>

            </tr>

            </thead>

            <tbody>

            @forelse($logs as $log)

                <tr>

                    <td>
                        {{ $log->created_at ?? $log->action_datetime ?? '-' }}
                    </td>

                    <td>
                        {{ $log->status ?? '-' }}
                    </td>

                    <td>
                        {{ $log->follow_date ?? '-' }}
                    </td>

                    <td>
                        {{ $log->remark }}
                    </td>

                    <td>
                        {{ $log->counselor_name ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center">
                        No Call Logs Found
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <h5 class="bg-dark text-white text-center p-2 mt-3">
        Notes
    </h5>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th width="80">Sno</th>

            <th>Remarks</th>

            <th>Updated By</th>

            <th>Action Datetime</th>

        </tr>

        </thead>

        <tbody>

        <tr>

            <td>{{ $lead->sno }}</td>

            <td>{{ $lead->notes ?? '-' }}</td>

            <td>{{ $lead->assign_name ?? '-' }}</td>

            <td>{{ $lead->updated_at ?? '-' }}</td>

        </tr>

        </tbody>

    </table>

</div>

<div class="modal-footer">

    <button class="btn btn-secondary"
            data-bs-dismiss="modal">
        Close
    </button>

</div>