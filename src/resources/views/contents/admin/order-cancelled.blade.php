@extends('layouts.admin.app')

@section('titlebar', 'Pengelolaan Pesanan')

@section('stylesheet')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content-header')
  <section class="content-header" id="breadcrum-header">
    <div class="container-fluid">
      Pesanan
    </div>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-4">
              <input type="text" id="searchTerm" class="form-control" placeholder="Cari id_payment atau connote">
            </div>
            <div class="col-md-4">
              <select id="logisticFilter" class="form-control">
                <option value="all">Semua Jenis Pengiriman</option>
                <option value="pick-up-order">Pick-up Order</option>
                <option value="cash-on-delivery">Cash on Delivery</option>
                <option value="bank">Bank</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="cancelledOrderTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID Payment</th>
                <th>Connote</th>
                <th>Logistik</th>
                <th>Jenis</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script>
    $(document).ready(function() {
      const cancelledOrderTable = $('#cancelledOrderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.order.cancel.view') }}',
          data: function(d) {
            d.searchTerm = $('#searchTerm').val();
            d.logistic = $('#logisticFilter').val();
          }
        },
        columns: [{
            data: 'id_payment',
            name: 'id_payment'
          },
          {
            data: 'connote',
            name: 'connote'
          },
          {
            data: 'logistic',
            name: 'logistic'
          },
          {
            data: 'type',
            name: 'type'
          },
        ],
        pageLength: 25,
        lengthMenu: [
          [5, 10, 15, 25],
          [5, 10, 15, 25]
        ],
      });

      $('#searchTerm, #logisticFilter').change(function() {
        cancelledOrderTable.draw();
      });
    });
  </script>
@endsection

@section('init')
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection
