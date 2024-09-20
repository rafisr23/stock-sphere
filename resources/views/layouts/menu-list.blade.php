<li class="pc-item pc-caption">
    <label>Menu</label>
</li>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext">Dashboard</span>
        {{-- <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        <span class="pc-badge">2</span> --}}
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
        <li class="pc-item"><a class="pc-link" href="/items">Items</a></li>
        @role('superadmin')
            <li class="pc-item"><a class="pc-link" href="{{ route('units.index') }}">Units</a></li>
        @endrole
    </ul>
</li>

{{-- <li class="pc-item pc-caption">
    <label>User Management</label>
</li> --}}
@role('superadmin')
    <li class="pc-item pc-hasmenu">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-users-three"></i>
            </span>
            <span class="pc-mtext">User Managament</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#">Account</a></li>
            <li class="pc-item"><a class="pc-link" href="#">Role & Permission</a></li>
        </ul>
    </li>
@endrole
