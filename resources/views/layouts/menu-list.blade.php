<li class="pc-item pc-caption">
    <label>Menu</label>
</li>
<li class="pc-item {{ request()->routeIs('home.index') ? 'active' : '' }}">
    <a href="{{ route('home.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-pie-slice"></i>
        </span>
        <span class="pc-mtext">Dashboard</span>
        {{-- <span class="pc-badge">2</span> --}}
    </a>
</li>

@role('superadmin|unit|room')
    <li class="pc-item pc-hasmenu">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-hard-drives"></i>
            </span>
            <span class="pc-mtext">Data Master</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="pc-submenu">
            @role('superadmin')
                <li class="pc-item {{ request()->routeIs('units.*') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('units.index') }}">Units</a></li>
                <li class="pc-item {{ request()->routeIs('technicians.*') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('technicians.index') }}">Technicians</a></li>
                <li class="pc-item {{ request()->routeIs('spareparts.*') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('spareparts.index') }}">Spareparts</a></li>
                <li class="pc-item {{ request()->routeIs('items.*') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('items.index') }}">Items</a></li>
            @endrole
            @role('superadmin|unit|room')
                <li class="pc-item {{ request()->routeIs('items_units.*') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('items_units.index') }}">Assign Items</a></li>
                @role('superadmin|unit')
                    <li class="pc-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}"><a class="pc-link"
                            href="{{ route('rooms.index') }}">Rooms</a></li>
                @endrole
            @endrole
        </ul>
    </li>
    {{-- <li class="pc-item pc-caption">
        <label>Repairs</label>
    </li> --}}
    
@endrole

@role('superadmin|technician|unit|room')
    <li class="pc-item pc-hasmenu">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-wrench"></i>
            </span>
            <span class="pc-mtext">Repairs</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
            @role('superadmin|technician')
                @foreach ($status_count as $sc)
                    <span class="pc-badge {{ $sc->status == 0 ? 'bg-warning' : ($sc->status == 1 ? 'bg-primary' : '') }}">
                        {{ $sc->total }}
                    </span>
                @endforeach
            @endrole
        </a>
        <ul class="pc-submenu">
            @role('superadmin|unit|room')
                <li class="pc-item {{ request()->routeIs('submission-of-repair.index') ? 'active' : '' }}">
                    <a href="{{ route('submission-of-repair.index') }}" class="pc-link">
                        <span class="pc-mtext">Submission</span>
                    </a>
                </li>
                <li
                    class="pc-item {{ request()->routeIs('submission-of-repair.history') || request()->routeIs('submission-of-repair.detail') ? 'active' : '' }}">
                    <a href="{{ route('submission-of-repair.history') }}" class="pc-link">
                        <span class="pc-mtext">History Of Submission</span>
                    </a>
                </li>
            @endrole
            @role('superadmin|technician')
                <li class="pc-item {{ request()->routeIs('detail_submission.index') ? 'active' : '' }}">
                    <a href="{{ route('repairments.index') }}" class="pc-link">
                        <span class="pc-mtext">Repairments</span>
                    </a>
                </li>
            @endrole
            @if (
                (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) ||
                    auth()->user()->hasRole('superadmin'))
                <li class="pc-item ">
                    <a href="{{ route('submission-of-repair.list') }}" class="pc-link">
                        <span class="pc-mtext">List Of Repairs</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endrole






@if (auth()->user()->hasRole('technician') || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('room'))
    <li class="pc-item pc-hasmenu">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-gear-six"></i>
            </span>
            <span class="pc-mtext">Maintenances</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
            @foreach ($maintenance_count as $mc)
                <span class="pc-badge {{ $mc->status == 0 ? 'bg-info' : ($mc->status == 1 ? 'bg-secondary' : '') }}">
                    {{ $mc->total }}
                </span>
            @endforeach
        </a>
        <ul class="pc-submenu">
            @if (!auth()->user()->hasRole('room'))
                <li class="pc-item {{ request()->routeIs('maintenances.index') ? 'active' : '' }}"><a class="pc-link"
                        href="{{ route('maintenances.index') }}">List</a></li>
            @endif
            <li class="pc-item {{ request()->routeIs('maintenances.history') ? 'active' : '' }}"><a class="pc-link"
                    href="{{ route('maintenances.history') }}">History</a></li>
            @if (auth()->user()->hasRole('room') || auth()->user()->hasRole('superadmin'))
                <li class="pc-item {{ request()->routeIs('maintenances.confirmation') ? 'active' : '' }}"><a
                        class="pc-link" href="{{ route('maintenances.confirmation') }}">Confirmation</a></li>
            @endif
        </ul>
    </li>
@endif

@role('superadmin')
    <li class="pc-item pc-caption">
        <label>System</label>
    </li>
    <li
        class="pc-item pc-hasmenu {{ request()->routeIs('user.*') || request()->routeIs('user.role.*') ? 'active pc-trigger' : '' }}">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-users-three"></i>
            </span>
            <span class="pc-mtext">User Managament</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="pc-submenu">
            <li class="pc-item {{ request()->routeIs('user.*') ? 'active' : '' }}"><a class="pc-link"
                    href="{{ route('user.index') }}">Accounts</a></li>
            {{-- <li class="pc-item {{ request()->routeIs('user.role') ? 'active' : '' }}"><a class="pc-link" href="{{ route('user.role') }}">Role & Permission</a></li> --}}
        </ul>
    </li>
    <li class="pc-item {{ request()->routeIs('log.*') ? 'active' : '' }}">
        <a href="{{ route('log.index') }}" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-list-dashes"></i>
            </span>
            <span class="pc-mtext">Logs</span>
        </a>
    </li>
@endrole
