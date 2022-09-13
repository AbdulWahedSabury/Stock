<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img id="profileImage" src="{{ auth()->user()->avatar_url }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ auth()->user()->name }}</a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
          class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>

      <!-- customers -->
      <li class="nav-item">
        <a href="{{ route('admin.customers') }}"
          class="nav-link {{ request()->is('admin/customers') ? 'active' : '' }}">
          <i class="nav-icon fas fa-address-book"></i>
          <p>
            customers
          </p>
        </a>
      </li>
      <!-- providers -->
      <li class="nav-item">
        <a href="{{ route('admin.providers') }}"
          class="nav-link {{ request()->is('admin/providers') ? 'active' : '' }}">
          <i class="fa fa-handshake"></i>
          <p>
            providers
          </p>
        </a>
      </li>
      <!-- stocks -->
      <li class="nav-item">
        <a href="{{ route('admin.stocks') }}" class="nav-link {{ request()->is('admin/stocks') ? 'active' : '' }}">
          <i class="fa fa-box"></i>
          <p>
            Stocks
          </p>
        </a>
      </li>
      <!-- product -->
      <li class="nav-item">
        <a href="{{ route('admin.products') }}"
          class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}">
          <i class="fa fa-list" aria-hidden="true"></i>
          <p>
            products
          </p>
        </a>
      </li>
      <!-- Inventories -->
      <li class="nav-item">
        <a href="{{ route('admin.inventory') }}"
          class="nav-link {{ request()->is('admin/inventories') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" style="height:24px;width:24px">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
          </svg>
          <p>
            Inventories
          </p>
        </a>
      </li>

      <!-- purchase -->
      <li class="nav-item">
        <a href="{{ route('admin.purchase') }}"
          class="nav-link {{ request()->is('admin/purchase') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" style="height:24px;width:24px">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
          </svg>
          <p>
            purchse
          </p>
        </a>
      </li>
      <!-- sales -->
      <li class="nav-item">
        <a href="{{ route('admin.sales') }}"
          class="nav-link {{ request()->is('admin/sales') ? 'active' : '' }}">
          <i class="fa fa-shopping-cart"></i>
          <p>
            Sales
          </p>
        </a>
      </li>
      <!-- users -->
      <li class="nav-item">
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Users
          </p>
        </a>
      </li>
      <!-- profile -->
      <li class="nav-item">
        <a href="{{ route('admin.profile.edit') }}"
          class="nav-link {{ request()->is('admin/profile/edit') ? 'active' : '' }}">
          <i class="nav-icon fas fa-user-circle"></i>
          <p>
            Profile
          </p>
        </a>
      </li>
      {{-- Log out --}}
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <a href="{{ route('logout') }}" class="nav-link {{ request()->is('logout') ? 'active' : '' }}"
            onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              logout
            </p>
          </a>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
