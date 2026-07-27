<h5 class="mb-3">
    Notes for :
    <strong>{{ $lead->sname }}</strong>
</h5>

<form id="addNoteForm">

    @csrf

    <input type="hidden"
           name="main_id"
           value="{{ $lead->sno }}">

    <div class="mb-3">

        <label class="form-label fw-bold">
            Add Note
        </label>

        <textarea class="form-control"
                  name="notes_remarks"
                  rows="4"></textarea>

    </div>

    <div class="text-end">

        <button class="btn btn-primary">

            Add Note

        </button>

    </div>

</form>

<hr>

<div class="table-responsive">

<table class="table table-bordered">

    <thead class="table-dark">

        <tr>

            <th width="80">Sno</th>

            <th>Remarks</th>

            <th>Updated By</th>

            <th>Action Datetime</th>

        </tr>

    </thead>

    <tbody>

    @forelse($notes as $note)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $note->notes_remarks }}</td>

            <td>{{ $note->created_name }}</td>

            <td>{{ $note->created_datetime }}</td>

        </tr>

    @empty

        <tr>

            <td colspan="4" class="text-center">

                No logs found

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

</div>