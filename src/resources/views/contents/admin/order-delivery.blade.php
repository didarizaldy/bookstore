@extends('layouts.admin.app')

@section('titlebar', 'Pengelolaan Pengiriman')

@section('stylesheet')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content-header')
  <section class="content-header" id="breadcrum-header">
    <div class="container-fluid">
      Pengiriman
    </div>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <input type="text" id="searchTerm" class="form-control" placeholder="Cari id_payment, paid_name, dll">
            </div>
            <div class="col-md-3">
              <select id="paymentStatusFilter" class="form-control">
                <option value="all">Semua Status Pembayaran</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
              </select>
            </div>
            <div class="col-md-3">
              <select id="deliveryStatusFilter" class="form-control">
                <option value="all">Semua Status Pengiriman</option>
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
          <table id="deliveryTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID Payment</th>
                <th>No. Rekening</th>
                <th>Bukti Pembayaran</th>
                <th>No. Resi</th>
                <th>Status Pembayaran</th>
                <th>Status Pengiriman</th>
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
      const deliveryTable = $('#deliveryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.order.delivery.view') }}',
          data: function(d) {
            d.searchTerm = $('#searchTerm').val();
            d.payment_status = $('#paymentStatusFilter').val();
            d.delivery_status = $('#deliveryStatusFilter').val();
          }
        },
        columns: [{
            data: 'id_payment',
            name: 'id_payment'
          },
          {
            data: 'paid_number_bank',
            name: 'paid_number_bank'
          },
          {
            data: 'paid_proof_link',
            name: 'paid_proof_link'
          },
          {
            data: 'connote',
            name: 'connote'
          },
          {
            data: 'payment_status',
            name: 'payment_status'
          },
          {
            data: 'delivery_status',
            name: 'delivery_status'
          }
        ],
        pageLength: 25,
        lengthMenu: [
          [5, 10, 15, 25],
          [5, 10, 15, 25]
        ],
        searching: false
      });

      $('#searchTerm, #paymentStatusFilter, #deliveryStatusFilter').change(function() {
        deliveryTable.draw();
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
