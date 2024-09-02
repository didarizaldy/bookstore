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
              <input type="text" id="searchTerm" class="form-control"
                placeholder="Cari id_payment, nama penerima, atau nomor telepon">
            </div>
            <div class="col-md-4">
              <select id="statusFilter" class="form-control">
                <option value="all">Semua Status</option>
                <option value="menunggu pembayaran">Menunggu Pembayaran</option>
                <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="diterima">Diterima</option>
                <option value="dibatalkan">Dibatalkan</option>
                <option value="ditolak">Ditolak</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="orderTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID Payment</th>
                <th>Status</th>
                <th>Type</th>
                <th>Connote</th>
                <th>Logistic</th>
                <th>Total Payment</th>
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
      const orderTable = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.order.view') }}',
          data: function(d) {
            d.searchTerm = $('#searchTerm').val();
            d.status = $('#statusFilter').val();
          }
        },
        columns: [{
            data: 'id_payment',
            name: 'id_payment'
          },
          {
            data: 'status-delivery',
            render: function(data, type, row) {
              return data.charAt(0).toUpperCase() + data.slice(1);
            }
          },
          {
            data: 'status-payment'
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
            data: 'total_pay',
            name: 'total_pay'
          }
        ],
        pageLength: 25,
        lengthMenu: [
          [5, 10, 15, 25],
          [5, 10, 15, 25]
        ],
      });

      $('#searchTerm, #statusFilter').change(function() {
        orderTable.draw();
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
