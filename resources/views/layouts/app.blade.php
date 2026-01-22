<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QuickPOS</title>

  <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('uploads/images/logo.png') }}">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- ✅ GLOBAL FIX (prevents "page break" when content too long) -->
  <style>
    html, body {
      height: 100%;
    }

    body {
      overflow-x: hidden;
    }

    /* ✅ Force wrapper to always contain content + footer properly */
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ✅ Let content-wrapper take remaining space */
    .content-wrapper {
      flex: 1;
      min-height: 0 !important;
      overflow-x: hidden;
    }

    /* ✅ Ensure content never goes under footer */
    .content {
      padding-bottom: 70px;
    }

    /* ✅ Footer always below content (not overlapping) */
    .main-footer {
      margin-top: auto;
      position: relative;
      z-index: 10;
    }
    
    /* Sidebar icon color */
.main-sidebar .nav-icon {
    color: #d2d2d2 !important; /* Example: orange, change to any color you like */
}

/* Optional: change icon color on hover */
.main-sidebar .nav-link:hover .nav-icon {
    color: #ffffff !important; /* Example: brighter yellow on hover */
}

/* Optional: change icon color for active page */
.main-sidebar .nav-link.active .nav-icon {
    color: #a8a8a8 !important; /* Example: darker orange for active link */
}
/* Sidebar font exactly like your HTML cards */
.main-sidebar,
.nav-sidebar .nav-item .nav-link,
.nav-sidebar .nav-header {
    font-family: 'Source Sans Pro', sans-serif; /* same as your cards */
}

/* Regular sidebar links */
.nav-sidebar .nav-item .nav-link {
    font-weight: 400;      /* normal weight, not bold */
    font-size: 0.85rem;    /* smaller, matches your HTML text */
    color: #ffffff;        /* white text */
    padding: 0.4rem 1rem;  /* tighter padding for smaller look */
}

/* Hover & active link styles */
.nav-sidebar .nav-item .nav-link:hover,
.nav-sidebar .nav-item .nav-link.active {
    color: #ffffff;                  /* keep white */
    background-color: rgba(255,255,255,0.05); /* subtle highlight */
}

/* Sidebar section headers */
.nav-sidebar .nav-header {
    font-weight: 400;    /* normal weight like body text */
    font-size: 0.75rem;  /* smaller than links */
    color: #c2c7d0;      /* light gray */
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 0.3rem 1rem;
}



  </style>

  @stack('styles')
  @vite('resources/js/app.js')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
@include('sweetalert::alert')

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/dashboard" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
          {{ ucwords(auth()->user()->name) }}
        </button>
        <div class="dropdown-menu">
          <button type="button" class="btn" data-toggle="modal" data-target="#formChangePassword">
            Change Password
          </button>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn text-danger">Logout</button>
          </form>
        </div>
      </div>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <x-admin.aside/>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('content_title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">@yield('content_title')</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <strong>
      Copyright &copy; 2014-2021
      <a href="https://adminlte.io">AdminLTE.io</a>.
    </strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte') }}/dist/js/adminlte.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    if ($('#table1').length) {
      $("#table1").DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
    }

    if ($('#table2').length) {
      $('#table2').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>rtip'
      });
    }
  });
</script>

@stack('scripts')
<x-user.form-change-password/>

</body>
</html>
