<div class="table-responsive">
    <table class="table table-bordered table-flush" id="evidenceTechnicianTable"
        style="border: 0px solid #e9ecef !important;" width="100%">
        <tr>
            <th>No</th>
            <th>Evidence</th>
        </tr>
        @if ($evidence_technician)
            @foreach ($evidence_technician as $e)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a class="card-gallery" target="_blank" data-fslightbox="gallery" href="{{ asset($e->evidence) }}">
                            <img class="img-fluid wid-50" src="{{ asset($e->evidence) }}" alt="">
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">No evidence provided</td>
            </tr>
        @endif
    </table>
    <form action="{{ route('repairments.storeEvidenceTechnician', encrypt($details_of_repair_submissions->id)) }}"
        method="post">
        @csrf
        <input type="file" name="repairments_evidence" id="repairments_evidence" class="form-control"
            placeholder="Add evidence repairment for {{ $details_of_repair_submissions->itemUnit->items->item_name }}">
        <div class="form-group row">
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Add Evidence</button>
            </div>
        </div>
    </form>
</div>


@section('script')
    <script>
        $(document).ready(function() {
            $('#evidenceTechnicianTable').DataTable();
        });
    </script>
@endsection
