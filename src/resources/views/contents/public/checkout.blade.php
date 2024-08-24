@extends('layouts.public.app')

@section('titlebar')
  Checkout
@endsection

@section('content-header')
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><strong>Checkout</strong></li>
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
        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
          <div class="card w-100">
            <div class="card-body">
              @if (!$shippingAddress)
                <h5 class="card-title"><strong>Wah Kosong</strong></h5>
                <p class="card-text">Silakan untuk menambahkan alamat dahulu pada setting <a
                    href="{{ route('public.user.setting') }}">disini</a></p>
              @else
                <h5 class="card-title"><strong>Alamat Pengiriman</strong></h5>
                <p class="card-text">{{ $shippingAddress->address }}, {{ $shippingAddress->phone }}</p>
              @endif
            </div>
          </div>

          @foreach ($cartItems as $item)
            <div class="card w-100 item-checkout">
              <div class="card-body border-bottom">
                <h5 class="card-title"><strong>Pesanan Ke - {{ $loop->iteration }}</strong></h5>
                <br>
                <div class="row align-items-center">
                  <div class="col-2">
                    <img src="{{ asset('assets/img/cover-book/' . $item->product->filename_img) }}"
                      alt="item-{{ $item->product->title }}" class="img-fluid">
                  </div>
                  <div class="col-5">
                    <p>{{ $item->product->title }}</p>
                  </div>
                  <div class="col-5 text-right">
                    <p>
                      <strong class="price-item-id">{{ $item->quantity }} x Rp
                        {{ number_format($item->product->display_price, 0, ',', '.') }}</strong>
                    </p>
                    <p>Ekspedisi : Pengiriman Toko
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach

        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <form id="purchase-form" action="{{ route('public.checkout.store') }}" method="POST">
            @csrf
            <div class="card w-100">
              <div class="card-body">
                <h5>Silakan Pilih Metode Bayar</h5>
                <div class="card-text">
                  <div class="form-group">
                    <label>Pilih Metode</label>
                    <select class="form-control" name="paymentMethod" id="payment-method">
                      @foreach ($bankAccount as $item)
                        <option value="bank-{{ $item->id }}">Bank {{ $item->bank_name }}</option>
                      @endforeach
                      <option value="cash-on-delivery">COD</option>
                      <option value="pick-up-order">Pick Up Order (Ambil Di Toko)</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="card w-100">

              <div class="card-body">
                <h5 class="card-title mb-3"><strong>Ringkasan Belanja</strong></h5>
                <p class="card-text d-flex justify-content-between">
                  <span>Total Harga ({{ $countTotalitem }})</span>
                  <strong id="total-item-price" class="text-end">
                    {{ number_format($totalPriceItems, 0, ',', '.') }}
                  </strong>
                </p>
                <p class="card-text d-flex justify-content-between">
                  <span>Total Ongkos Kirim ({{ $countTotalitem }})</span>
                  @if (count($cartItems) > 15)
                    <strong id="total-delivery-price" class="text-end">
                      {{ number_format($deliveryPrice, 0, ',', '.') }}
                    </strong>
                  @else
                    <strong id="total-delivery-price" class="text-end">
                      Gratis
                    </strong>
                  @endif
                </p>
                <p class="card-text d-flex justify-content-between">
                  <span>Total Charge Package</span>
                  @if (count($cartItems) > 15)
                    <strong id="total-delivery-price" class="text-end">
                      {{ number_format($packagePrice, 0, ',', '.') }}
                    </strong>
                  @else
                    <strong id="total-delivery-price" class="text-end">
                      Gratis
                    </strong>
                  @endif
                </p>
                <p class="card-text d-flex justify-content-between">
                  <span>Kode Bayar Unik</span>
                  <strong id="total-item-price" class="text-end">
                    {{ number_format($uniqueCodePayment, 0, ',', '.') }}
                  </strong>
                </p>
                <hr>
                <p class="card-text d-flex justify-content-between">
                  <span>Total Bayar</span>
                  <strong id="total-price" class="text-end">
                    {{ number_format($totalPay, 0, ',', '.') }}
                  </strong>
                </p>

                <input type="hidden" name="selectedItems" id="selected-items" value="{{ json_encode($selectedItems) }}">
                <button type="submit" class="btn btn-success btn-block" style="border-radius: 12px">Bayar</button>
              </div>
          </form>
        </div>
      </div>

    </div>

    </div>
    </div>
  </section>
@endsection

@section('javascript')
  <script>
    const selectedItemsInput = document.getElementById('selected-items');
    document.addEventListener('DOMContentLoaded', function() {
      const paymentMethodSelect = document.getElementById('payment-method');
      if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', function() {
          const selectedItems = JSON.parse(selectedItemsInput.value); // Get existing data
          selectedItems.paymentMethod = this.value; // Add payment method
          selectedItemsInput.value = JSON.stringify(selectedItems); // Update hidden input
        });
      }
    });


    // Handle form submission and potential errors
    const purchaseForm = document.getElementById('purchase-form');
    purchaseForm.addEventListener('submit', (event) => {
      event.preventDefault();

      const formData = new FormData(purchaseForm);
      const data = Object.fromEntries(formData.entries());

      fetch('{{ route('public.checkout.store') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Redirect to payment page
            window.location.href = '{{ route('public.payment.view') }}';
          } else {
            // Display errors using SweetAlert
            if (data.errors) {
              let errorMessage = '<br>';
              data.errors.forEach((error) => {
                errorMessage += '- ' + error + '<br>'; // Add each error on a new line using <br>
              });
              Swal.fire({
                icon: 'error',
                title: 'Pemberitahuan',
                html: errorMessage // Use HTML to display the formatted error message
              });
            } else {
              // Handle other errors
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Something went wrong'
              });
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An error occurred'
          });
        });
    });
  </script>
@endsection
