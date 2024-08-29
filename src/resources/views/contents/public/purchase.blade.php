@extends('layouts.public.app')

@section('titlebar')
  Pembelian
@endsection

@section('content-header')
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><strong>Pembelian</strong></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          @include('layouts.public.mini-sidebar')

        </div>

        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
          @foreach ($purchase as $paidItem)
            @foreach ($paidItem->checkout as $checkoutItem)
              <div class="card w-100 item-checkout">
                <div class="card-body border-bottom">
                  <h5 class="card-title">
                    <strong>{{ $checkoutItem->invoice }}</strong>
                    @if ($paidItem->status == 'unpaid' && $paidItem->expired_at >= now())
                      <strong class="font-weight-normal" style="color: red">Menunggu Pembayaran</strong>
                    @else
                      <strong class="font-weight-normal"
                        style="color: green">{{ ucfirst($paidItem->delivery->status) }}</strong>
                    @endif
                  </h5>
                  <br>
                  <div class="row align-items-center">
                    <div class="col-2">
                      <img src="{{ asset('assets/img/cover-book/' . $checkoutItem->product->filename_img) }}"
                        alt="item-{{ $checkoutItem->product->title }}" class="img-fluid">
                    </div>
                    <div class="col-5">
                      <ul class="list-group">
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          <strong style="color: black">{{ $checkoutItem->product->title }}</strong>
                        </li>
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          {{ $checkoutItem->quantity }} Barang x Rp
                          {{ number_format($checkoutItem->product->display_price, 0, ',', '.') }}</li>
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Ongkos Kirim {{ $checkoutItem->fee_shipping }}
                        </li>
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Ongkos Packaging {{ $checkoutItem->fee_package }}
                        </li>
                        <li class="list-group-item-light d-flex justify-content-between align-items-center">
                          Resi : {{ $paidItem->delivery->connote }}
                        </li>
                      </ul>
                    </div>
                    <div class="col-5 text-right">
                      <p>
                        <strong class="price-item-id">{{ $checkoutItem->quantity }} x Rp
                          {{ number_format($checkoutItem->total_price, 0, ',', '.') }}</strong>
                      </p>
                      <p>Ekspedisi : {{ ucfirst($paidItem->delivery->type) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endforeach
        </div>

      </div>

    </div>
    </div>
  </section>
@endsection

@section('javascript')
  <script></script>
@endsection
