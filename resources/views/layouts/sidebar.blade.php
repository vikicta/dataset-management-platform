<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DATASET MGT<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mb-3">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>


    <!-- Nav Tasks for user-->
    @if (Auth::guard('annotator')->check())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('annotator.task.not.booked') }}">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>Tasks</span></a>
    </li>

    <!-- Nav My Tasks for user -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('annotator.task.my.tasks') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>My Tasks</span></a>
    </li>

    @else

    {{-- Nav Anntator for admin --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('annotator.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Annotator</span></a>
    </li>

    {{-- Nav Tasks for admin --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('task.index') }}">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>Tasks</span></a>
    </li>

    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
