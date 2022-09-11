<!DOCTYPE html>
<html lang="en">

<head>
  <x-layout.header>
  </x-layout.header>
  @livewireStyles
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <x-layout.Navbar>
      </x-loyout.Navbar>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <x-layout.Sidebar>
          </x-loyout.Sidebar>
      </aside>
      <div class="content-wrapper">
        {{ $slot }}
      </div>
      <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
          <h5>Title</h5>
          <p>Sidebar content</p>
        </div>
      </aside>
      <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
          Anything you want
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
  </div>

  <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/sweetAlert/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/moment.js') }}"></script>
  <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/alpine.js/alpine.js') }}"></script>
  <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>




  <script>
    window.addEventListener('error', event => {
      $('#form').modal('hide');
      toastr.warning(event.detail.message, 'warning!');
    })
    window.addEventListener('show-form', event => {
      $('#form').modal('show');
    })
    window.addEventListener('hide-form', event => {
      $('#form').modal('hide');
    })
    $(document).ready(function() {
      toastr.options = {
        "positionClass": "toast-bottom-right",
        "progressBar": true,
      }
      window.addEventListener('hide-form', event => {
        $('#form').modal('hide');
        toastr.success(event.detail.message, 'Success!');
      })
    })
    window.addEventListener('show-delete-form', event => {
      $('#deleteConfirmatinForm').modal('show');
    })
    window.addEventListener('hide-delete-form', event => {
      $('#deleteConfirmatinForm').modal('hide');
      toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('changed', event => {
      toastr.success(event.detail.message, 'Success!');
    })
  </script>
  @stack('styles')
  @stack('js')
  @livewireScripts
</body>

</html>
