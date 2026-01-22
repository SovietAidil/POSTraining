  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Brand Logo -->
  <a href="/dashboard" class="brand-link text-center">
    <img src="{{ asset('uploads/images/logo.png') }}" 
         alt="Logo" 
         class="brand-image" 
         style="opacity: .8; width: 50px; height: 50px; object-fit: cover;">
    <span class="brand-text font-weight-light text-bold text-center">{{ env('APP_NAME') }}</span>
  </a>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" style="min-height 100vh;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         {{-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>
              
      <!-- Sidebar Menu -->
      <nav class="mt-2 nav-sidebar flex-grow-1">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @foreach ($routes as $route)

    {{-- NORMAL MENU ITEM --}}
    @if (! $route['is_dropdown'])
        <li class="nav-item">
            <a href="{{ route($route['route_name']) }}"
               class="nav-link {{ request()->routeIs($route['route_active']) ? 'active' : '' }}">
                <i class="nav-icon {{ $route['icon'] }}"></i>
                <p>{{ $route['label'] }}</p>
            </a>
        </li>

    {{-- DROPDOWN MENU --}}
    @else
        <li class="nav-item {{ request()->routeIs($route['route_active']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon {{ $route['icon'] }}"></i>
                <p>
                    {{ $route['label'] }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                @foreach ($route['dropdown'] as $item)
                    <li class="nav-item">
                        <a href="{{ route($item['route_name']) }}"
                           class="nav-link {{ request()->routeIs($item['route_active']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ $item['label'] }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif

@endforeach

        </ul>
      </nav>
      <div class="mt-auto mb-3 text-center text-white">
    <small>© 2026 {{ env('APP_NAME') }}</small>
    </div>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
