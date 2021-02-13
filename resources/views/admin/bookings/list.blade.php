@extends('layouts.admin')

@section('page_css')
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link ref='stylesheet' href='{{ asset("admin/app-assets/css/jquery.fancybox.min.css") }}' />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <!-- END: Vendor CSS-->

@endSection()

@section('content')
    <!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Booking Table</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("centers.new_center_form") }}' class='btn btn-info'>
                <i class='fas fa-plus'></i>
                Create New Booking
            </a>
          </p>
            @if($bookings && $bookings != null)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered complex-headers" id="booking_table">
                    <thead>
                        <tr>
                        <th rowspan="2" class="align-center">Room</th>
                        <th colspan="3" class="text-center bg-dark text-white">Guest Information</th>
                        <th colspan="2" class='text-center  bg-dark text-white'>Usage Information</th>
                        <th rowspan="2" class='bg-success'>Action</th>
                        </tr>
                        <tr class=''>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Check In Date</th>
                        <th>Room Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($bookings as $booking)
                            @endforeach  
                        </tbody>
                    <tfoot>
                        <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Office</th>
                        <th>Extn.</th>
                        <th>E-mail</th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            @else
                <div class='text-center'>
                        <h4>No active Booking</h4>
                </div>
            @endif
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
    @if($bookings)
        <!-- BEGIN: Page Vendor JS-->
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
        <script src="{{ asset ('admin/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
        <!-- END: Page Vendor JS-->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#booking_table").DataTable();
            });
        </script>
    @endif
@endSection()