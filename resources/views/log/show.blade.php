@extends('layouts.main')

@section('title', 'Logs')
@section('breadcrumb-item', 'System')

@section('breadcrumb-item-active', 'Logs')

@section('css')
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Log Detail</h4>
                    <a href="{{ route('log.index') }}" class="btn btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    <table id="log_table" class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Norec</th>
                                <td>{{ $log->norec }}</td>
                            </tr>
                            <tr>
                                <th>Norec Parent</th>
                                <td>{{ $log->norec_parent ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ $log->ip }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $log->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Module</th>
                                <td>{{ $log->module_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Activity</th>
                                <td>{{ $log->desc ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Old Data</th>
                                <td>{{ $log->old_data ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Item Unit</th>
                                <td>{{ $log->item_unit->items->item_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Technician</th>
                                <td>{{ $log->technician->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Is Repair</th>
                                <td>{{ $log->is_repair == 1 ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Is Maintenance</th>
                                <td>{{ $log->is_maintenance == 1 ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Is Generic</th>
                                <td>{{ $log->is_generic == 1 ? 'Yes' : 'No' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    
@endsection
