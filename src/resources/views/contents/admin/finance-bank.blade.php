@extends('layouts.admin.app')

@section('titlebar')
  Pengelolaan Rekening
@endsection

@section('stylesheet')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content-header')
  <section class="content-header" id="breadcrum-header">
    <div class="container-fluid">
      Rekening
    </div>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table id="bankAccountTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Kode Bank</th>
                <th>Nama Rekening</th>
                <th>Nomer Rekening</th>
                <th>Status</th>
                <th>Tindakan</th>
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
      const bankAccountTable = $('#bankAccountTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.bank.view') }}',
        },
        columns: [{
            data: 'bank_name',
            render: function(data, type, row) {
              return data + ' (' + row.bank_code +
                ')';
            },
            name: 'bank_code_and_name'
          },
          {
            data: 'account_name',
            name: 'account_name'
          },
          {
            data: 'account_code',
            name: 'account_code'
          },
          {
            data: 'active',
            name: 'active',
            render: function(data, type, row) {
              if (data == 1) {
                return '<button type="button" class="btn btn-success btn-sm">Aktif</button>';
              } else {
                return '<button type="button" class="btn btn-danger btn-sm">Tidak Aktif</button>';

              }
            },
          },
          {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
          }
        ],
        pageLength: 5,
        lengthMenu: [
          [5, 10, 15, 25],
          [5, 10, 15, 25]
        ],
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
