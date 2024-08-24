@extends('layouts.admin.app')

@section('titlebar')
  Dashboard
@endsection

@section('stylesheet')
  <style>
    hr.vertical {
      height: 100%;
      /* you might need some positioning for this to work, see other questions about 100% height */
      width: 0;
      border: 1px solid black;
    }
  </style>
@endsection

@section('content-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <h3 class="m-0">Dashboard</h3>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content-header -->
@endsection


@section('content')
  <div class="card">
    <div class="card-body">
      <div class="row text-center">
        <div class="col-md-3 col-sm-6 col-12 border-right" style="border-right: 1px solid #ccc;">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Belum Bayar</span>
              <span class="info-box-number">{{ $paidYetCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 border-right" style="border-right: 1px solid #ccc;">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Pesanan Perlu Diproses</span>
              <span class="info-box-number">{{ $shippingNeedProcessCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 border-right" border-right: 1px solid #ccc;>
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Pesanan Diproses</span>
              <span class="info-box-number">{{ $shippingProcessCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Pesanan Dibatalkan</span>
              <span class="info-box-number">{{ $shippingCancelCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <br>
      <div class="row text-center">
        <div class="col-md-3 col-sm-6 col-12 border-right" style="border-right: 1px solid #ccc;">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Total Produk</span>
              <span class="info-box-number">{{ $productCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 border-right" style="border-right: 1px solid #ccc;">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Produk Hampir Habis</span>
              <span class="info-box-number">{{ $productAlmostEmptyCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 border-right" border-right: 1px solid #ccc;>
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Produk Kosong</span>
              <span class="info-box-number">{{ $productEmptyCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box shadow-none">
            <div class="info-box-content">
              <span class="info-box-text">Produk Diskon</span>
              <span class="info-box-number">{{ $productDiscount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
@endsection
