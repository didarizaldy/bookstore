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
        <div class="card-header">
          <button id="addBankAccountBtn" class="btn btn-sm btn-success">Tambah Rekening</button>
        </div>
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

  <!-- Add/Edit Bank Account Modal -->
  <div class="modal fade" id="bankAccountModal" tabindex="-1" role="dialog" aria-labelledby="bankAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="bankAccountForm">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="bankAccountModalLabel">Tambah Rekening</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="bankAccountId" name="id">
            <div class="form-group">
              <label for="bank_code">Kode Bank</label>
              <input type="text" class="form-control" id="bank_code" name="bank_code" required>
            </div>
            <div class="form-group">
              <label for="bank_name">Nama Bank</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" required>
            </div>
            <div class="form-group">
              <label for="account_name">Nama Rekening</label>
              <input type="text" class="form-control" id="account_name" name="account_name" required>
            </div>
            <div class="form-group">
              <label for="account_code">Nomor Rekening</label>
              <input type="text" class="form-control" id="account_code" name="account_code" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
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

      // Handle Add Button Click
      $('#addBankAccountBtn').click(function() {
        $('#bankAccountModalLabel').text('Tambah Rekening');
        $('#bankAccountForm')[0].reset();
        $('#bankAccountId').val('');
        $('#bankAccountModal').modal('show');
      });

      // Handle Edit Button Click
      $('#bankAccountTable').on('click', '.btn-primary', function() {
        console.log("click");
        const data = bankAccountTable.row($(this).parents('tr')).data();
        $('#bankAccountModalLabel').text('Edit Rekening');
        $('#bankAccountId').val(data.id);
        $('#bank_code').val(data.bank_code);
        $('#bank_name').val(data.bank_name);
        $('#account_name').val(data.account_name);
        $('#account_code').val(data.account_code);
        $('#bankAccountModal').modal('show');
      });

      // Handle Form Submission for Add/Edit
      const routes = {
        store: '{{ route('admin.bank.store') }}',
        update: '{{ route('admin.bank.update', ['id' => 'ID']) }}',
        deactive: '{{ route('admin.bank.deactive', ['id' => 'ID']) }}'
      };

      function replaceId(url, id) {
        return url.replace('ID', id);
      }


      $('#bankAccountForm').submit(function(e) {
        e.preventDefault();
        const id = $('#bankAccountId').val();
        const url = id ? replaceId(routes.update, id) : replaceId(routes.store);
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              bank_code: $('#bank_code').val(),
              bank_name: $('#bank_name').val(),
              account_name: $('#account_name').val(),
              account_code: $('#account_code').val(),
            }),
          })
          .then(response => response.json())
          .then(data => {
            $('#bankAccountModal').modal('hide');
            bankAccountTable.ajax.reload(null, false);
            Swal.fire('Berhasil!', data.message, 'success');
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
          });
      });

      // Handle Deactivate Button Click
      $('#bankAccountTable').on('click', '.btn-danger', function() {
        const data = bankAccountTable.row($(this).parents('tr')).data();
        const url = replaceId(routes.deactive, data.id);

        Swal.fire({
          title: 'Anda yakin?',
          text: "Akun akan dinonaktifkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, nonaktifkan!'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(url, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  'Content-Type': 'application/json',
                },
              })
              .then(response => response.json())
              .then(data => {
                bankAccountTable.ajax.reload(null, false);
                Swal.fire('Berhasil!', data.message, 'success');
              })
              .catch(error => {
                console.error('Error:', error);
                Swal.fire('Gagal!', 'Terjadi kesalahan disini.', 'error');
              });
          }
        });
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
