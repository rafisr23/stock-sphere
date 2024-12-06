<div class="table-responsive">
    <table class="table table-bordered table-flush" id="log_table" style="border: 0px solid #e9ecef !important;"
        width="100%">
        <tr>
            <th>Activity</th>
            <th>IP Address</th>
            <th>User</th>
            <th>Date</th>
        </tr>
        @if (count($logs) > 0)
            @foreach ($logs as $log)
                <tr>
                    <td class="text-wrap">{{ $log->desc }}</td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">No logs found</td>
            </tr>
        @endif
    </table>
</div>

@section('scripts')
    <script>
        $().ready(function() {
            $('#log_table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "scrollX": true,
                "scrollY": true,
                "scrollCollapse": true,
                "pagingType": "full_numbers",
                "pageLength": 10,
            });
            $("#log_table").css('width', '100%');
            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                console.log(message);
            };
        });
    </script>
@endsection
