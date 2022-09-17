<x-admin-layout>
  <div>

    <div>
      <x-content-header title="Dashboard">
      </x-content-header>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $usersCount }}</h3>
                    </div>
                    <p>Users <i class="fa fa-users"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.users') }}" class="small-box-footer">View Users
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $customersCount }}</h3>
                    </div>
                    <p>Customers <i class="fa fa-users"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.customers') }}" class="small-box-footer">View customers
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $providersCount }}</h3>
                    </div>
                    <p>Providers <i class="fa fa-handshake"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.providers') }}" class="small-box-footer">View Providers
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-dark">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $stocksCount }}</h3>
                    </div>
                    <p>Stocks <i class="fa fa-box"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.stocks') }}" class="small-box-footer">View Stocks
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $totalPurchase }} AF</h3>
                    </div>
                    <p>Purchase <i class="fa fa-dollar-sign"></i> </p>

                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.purchase') }}" class="small-box-footer">View Purchase
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $totalSale }} AF</h3>
                    </div>
                    <p>Sale <i class="fa fa-dollar-sign"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.sales') }}" class="small-box-footer">View Sales
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                <div class="inner">
                    <div class="d-flex justify-content-between">
                    <h3>{{ $totalInventory }}</h3>
                    </div>
                    <p>Inventories <i class="fa fa-list"></i> </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.inventory') }}" class="small-box-footer">View Inventories
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
        </div>

      </div>
    </div>

  </div>
</x-admin-layout>
