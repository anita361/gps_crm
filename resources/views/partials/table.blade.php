<div class="table-responsive">

    <table class="table table-bordered table-striped align-middle">

        <thead class="table-dark">

            <tr>

                <th width="80">Notes</th>
                <th>Follow On</th>
                <th>Name</th>
                <th>Number</th>
                <th>Source</th>
                <th>Counselor Name</th>
                <th>View / Update</th>
                <th width="120">Logs</th>

            </tr>

        </thead>

        <tbody>

            @forelse($leads as $lead)
                <tr>

                    <td>

                        <a href="{{ route('lead.followup.notes', $lead->sno) }}" class="btn btn-primary btn-sm notesBtn">

                            Notes

                        </a>

                    </td>

                    <td>

                        {{ $lead->follow_date }}

                    </td>

                    <td>

                        {{ $lead->sname }}

                    </td>

                    <td>

                        {{ $lead->smobile }}

                    </td>

                    <td>

                        {{ $lead->lead_source ?? '-' }}

                    </td>

                    <td>

                        {{ $lead->counselor_name ?? '-' }}

                    </td>

                    <td>

                        <a href="{{ route('walking-details', $lead->smobile) }}" class="btn btn-success btn-sm">

                            View / Update

                        </a>

                    </td>

                    <td>

                        <button type="button" class="btn btn-info btn-sm callLogsBtn" data-id="{{ $lead->sno }}">
                            <i class="fa fa-phone"></i> Call Logs
                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">

                        No Followups Found

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-3">

    {{ $leads->links() }}

</div>
