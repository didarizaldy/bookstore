@extends('layouts.admin.app')

@section('titlebar')
  Pengelolaan User
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
      User
    </div>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <button id="addUserBtn" class="btn btn-sm btn-success">Tambah User</button>
        </div>
        <div class="card-body">
          <table id="userTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Status</th>
                <th>Login Terakhir</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit Bank Account Modal -->
  <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="userForm">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="userId" name="id">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="fullname">Nama Lengkap</label>
              <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
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
      const userTable = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.user.view') }}',
        },
        columns: [{
            data: 'fullname',
            name: 'fullname'
          },
          {
            data: 'email',
            name: 'email'
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
            data: 'last_login_at',
            name: 'last_login_at'
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
      $('#addUserBtn').click(function() {
        $('#userModalLabel').text('Tambah User');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModal').modal('show');
      });

      // Handle Edit Button Click
      $('#userTable').on('click', '.btn-primary', function() {
        console.log("click");
        const data = userTable.row($(this).parents('tr')).data();
        $('#userModalLabel').text('Edit User');
        $('#userId').val(data.id);
        $('#username').val(data.username);
        $('#fullname').val(data.fullname);
        $('#email').val(data.email);
        $('#password').val(data.password);
        $('#userModal').modal('show');
      });

      // Handle Form Submission for Add/Edit
      const routes = {
        store: '{{ route('admin.user.store') }}',
        update: '{{ route('admin.user.update', ['id' => 'ID']) }}',
        deactive: '{{ route('admin.user.deactive', ['id' => 'ID']) }}'
      };

      function replaceId(url, id) {
        return url.replace('ID', id);
      }


      $('#userForm').submit(function(e) {
        e.preventDefault();
        const id = $('#userId').val();
        const url = id ? replaceId(routes.update, id) : replaceId(routes.store);
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              username: $('#username').val(),
              fullname: $('#fullname').val(),
              email: $('#email').val(),
              password: $('#password').val(),
            }),
          })
          .then(response => response.json())
          .then(data => {
            $('#userModal').modal('hide');
            userTable.ajax.reload(null, false);
            Swal.fire('Berhasil!', data.message, 'success');
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
          });
      });

      // Handle Deactivate Button Click
      $('#userTable').on('click', '.btn-danger', function() {
        const data = userTable.row($(this).parents('tr')).data();
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
                userTable.ajax.reload(null, false);
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
