<li class="pc-item pc-caption">
    <label>Menu</label>
</li>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-pie-slice"></i>
        </span>
        <span class="pc-mtext">Dashboard</span>
        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        {{-- <span class="pc-badge">2</span> --}}
    </a>
    <ul class="pc-submenu">
        <li class="pc-item"><a class="pc-link" href="/">Analytics</a></li>
    </ul>
</li>
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
            <li class="pc-item"><a class="pc-link" href="{{ route('units.index') }}">Units</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('technicians.index') }}">Technicians</a></li>
        @endrole
        @role('superadmin|unit')
            <li class="pc-item"><a class="pc-link" href="{{ route('items.index') }}">Items</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('items_units.index') }}">Assign Items</a></li>
        @endrole
    </ul>
</li>
{{-- <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link"><span class="pc-micon"> <i class="ph-duotone ph-layout"></i></span><span
            class="pc-mtext">Layouts</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
    <ul class="pc-submenu">
        <li class="pc-item"><a class="pc-link" href="/demo/layout-horizontal">Horizontal</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-vertical">Vertical</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-vertical-tab">Vertical + Tab</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-tab">Tab</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-2-column">2 Column</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-big-compact">Big Compact</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-compact">Compact</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-moduler">Moduler</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-creative">Creative</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-detached">Detached</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-advanced">Advanced</a></li>
        <li class="pc-item"><a class="pc-link" href="/demo/layout-extended">Extended</a></li>
    </ul>
</li>

{{-- <li class="pc-item pc-caption">
    <label>User Management</label>
</li> --}}
@role('superadmin')
    <li class="pc-item pc-hasmenu {{ request()->routeIs('user.*') || request()->routeIs('user.role.*') ? 'active pc-trigger' : '' }}">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-users-three"></i>
            </span>
            <span class="pc-mtext">User Managament</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="pc-submenu">
            <li class="pc-item {{ request()->routeIs('user.*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('user.index') }}">Account</a></li>
            {{-- <li class="pc-item {{ request()->routeIs('user.role') ? 'active' : '' }}"><a class="pc-link" href="{{ route('user.role') }}">Role & Permission</a></li> --}}
        </ul>
    </li>
@endrole

<li class="pc-item pc-caption">
    <label>Repairs</label>
</li>
<li class="pc-item {{ request()->routeIs('submission-of-repair.index') ? 'active' : '' }}">
    <a href="{{ route('submission-of-repair.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-wrench"></i>
        </span>
        <span class="pc-mtext">Submission Of Repairs</span>
    </a>
</li>
<li class="pc-item {{ request()->routeIs('submission-of-repair.history') ? 'active' : '' }}">
    <a href="{{ route('submission-of-repair.history') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-clock-counter-clockwise"></i>
        </span>
        <span class="pc-mtext">History Of Submission</span>
    </a>
</li>
