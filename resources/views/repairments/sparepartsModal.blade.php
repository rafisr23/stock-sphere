<div class="table-responsive">
    <table class="table table-bordered table-flush" id="sparepartUsedTable" style="border: 0px solid #e9ecef !important;"
        width="100%">
        <tr>
            <th>Sparepart name</th>
            <th>Serial Number</th>
            <th>Description</th>
        </tr>
        @if (count($sparepartUsed) > 0)
            @foreach ($sparepartUsed as $sparepart)
                <tr>
                    <td>{{ $sparepart["name"] }}</td>
                    <td>{{ $sparepart["serial_no"] }}</td>
                    <td>{{ $sparepart["description"] }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">No spareparts used</td>
            </tr>
        @endif
    </table>
</div>

@section('scripts')
    <script>
        $().ready(function() {
            $('#sparepartUsedTable').dataTable();
            $("#sparepartUsedTable").css('width', '100%');
            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                console.log(message);
            };
        });
    </script>
@endsection
