@extends('layouts.admin.app')

@section('titlebar')
  Pengelolaan Produk
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
      Produk
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
              <select id="categoryFilter" class="form-control">
                <option value="all">Semua Kategori</option>
                @foreach ($showCategories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <select id="sortFilter" class="form-control">
                <option value="last_created">Terbaru</option>
                <option value="high_price">Harga Tertinggi</option>
                <option value="low_price">Harga Terendah</option>
                <option value="last_updated">Terakhir Diperbarui</option>
                <option value="old_created">Paling Lama</option>
                <option value="alphabet_a_z">A-Z</option>
                <option value="alphabet_z_a">Z-A</option>
              </select>
            </div>
            <div class="col-md-4 text-right">
              <button id="addProductBtn" class="btn btn-success" data-toggle="modal" data-target="#productModal">Tambah
                Produk</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="productTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>SKU</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Tindakan</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Add Product -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addProductForm">
            @csrf
            <!-- Form fields for the product -->
            <div class="form-group">
              <label for="addTitle">Judul</label>
              <input type="text" class="form-control" id="addTitle" name="title" required>
            </div>
            <div class="form-group">
              <label for="addCategory">Kategori</label>
              <select class="form-control" id="addCategory" name="id_category" required>
                @foreach ($showCategories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="addDisplayPrice">Harga</label>
              <input type="number" class="form-control" id="addDisplayPrice" name="display_price" required>
            </div>
            <div class="form-group">
              <label for="addStocks">Stok</label>
              <input type="number" class="form-control" id="addStocks" name="stocks" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveAddProductBtn">Simpan</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('javascript')
  <script>
    $(document).ready(function() {
      const productTable = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('admin.product.view') }}',
          data: function(d) {
            d.category = $('#categoryFilter').val();
            d.sort = $('#sortFilter').val();
          }
        },
        columns: [{
            data: 'sku',
            name: 'sku'
          },
          {
            data: 'title',
            name: 'title'
          },
          {
            data: 'category',
            name: 'category'
          },
          {
            data: 'display_price',
            name: 'display_price',
            render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
          },
          {
            data: 'stocks',
            name: 'stocks'
          },
          {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
              return `
                <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
              `;
            }
          }
        ],
        pageLength: 25,
        lengthMenu: [
          [5, 10, 15, 25],
          [5, 10, 15, 25]
        ],
      });

      $('#categoryFilter, #sortFilter').change(function() {
        productTable.draw();
      });
      const routes = {
        store: '{{ route('admin.product.add') }}',
        destroy: '{{ route('admin.product.delete', ['id' => 'ID']) }}'
      };

      function replaceId(url, id) {
        return url.replace('ID', id);
      }

      $('#addProductBtn').click(function() {
        $('#addProductForm')[0].reset();
        $('#addProductModal').modal('show');
      });

      $('#saveAddProductBtn').click(function() {
        const formData = new FormData(document.getElementById('addProductForm'));

        fetch(routes.store, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            $('#addProductModal').modal('hide');
            productTable.draw(false);
            alert(data.message);
          })
          .catch(error => console.error('Error adding product:', error));
      });

      $('#productTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const url = `{{ route('admin.product.edit', ['id' => 'ID']) }}`.replace('ID', id);
        window.location.href = url;
      });

      $('#productTable').on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this product?')) {
          const id = $(this).data('id');
          const url = replaceId(routes.destroy, id);

          fetch(url, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            })
            .then(response => response.json())
            .then(data => {
              productTable.draw(false);
              alert(data.message);
            })
            .catch(error => console.error('Error deleting product:', error));
        }
      });

      $('#categoryFilter, #sortFilter').change(function() {
        productTable.draw();
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
