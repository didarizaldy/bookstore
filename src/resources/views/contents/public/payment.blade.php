@extends('layouts.public.app')

@section('titlebar')
  Pembayaran
@endsection

@section('content')
  <section class="content">
    <div class="container h-100">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="text-center">
            <h3 class="mt-4 mb-0"><strong>Selangkah lagi nih.</strong></h3>
            @if ($payment->payment == 'pick-up-order')
              <p class="text-muted mt-3 mb-0">Batas Akhir Pengambilan</p>
              <strong>{{ Carbon\Carbon::parse($payment->expired_at)->isoFormat('dddd, D MMMM YYYY H:mm') }}</strong>
            @elseif ($payment->payment == 'cash-on-delivery')
              <p class="text-muted mt-3 mb-0">Pesanan kamu akan kami konfirmasi paling lama</p>
              <strong>{{ Carbon\Carbon::parse($payment->expired_at)->isoFormat('dddd, D MMMM YYYY H:mm') }}</strong>
            @else
              <p id="countdown" style="color: chocolate;"></p>
              <p class="text-muted mt-3 mb-0">Batas Akhir Pembayaran</p>
              <strong>{{ Carbon\Carbon::parse($payment->expired_at)->isoFormat('dddd, D MMMM YYYY H:mm') }}</strong>
            @endif

            <div class="card text-center mt-3">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5 class="text-center"><strong>Detail Payment</strong></h5>
                  </div>
                  <div class="col-sm-6">
                    @if (!empty($payment->bank))
                      <h5 class="text-center text-muted"><span text-decoration:
                          none;">{{ $payment->bank->bank_name }}</span>
                      </h5>
                    @else
                      <h5 class="text-center"><span
                          style="color: rgb(87, 177, 87); text-decoration: none;">{{ str_replace("'", '"', ucwords($payment->payment)) }}</span>
                      </h5>
                    @endif
                  </div>
                </div>
              </div>
              <div class="card-body">
                @if (!empty($payment->bank))
                  <p class="card-text d-flex justify-content-between mb-0">
                    <strong>Nama Bank</strong>
                    <strong>Nama Akun</strong>
                  </p>
                  <p class="card-text d-flex justify-content-between mb-0">
                    <span class="text-muted">{{ $payment->bank->bank_name }} ({{ $payment->bank->bank_code }})</span>
                    <span class="text-muted">{{ $payment->bank->account_name }}</span>
                  </p>
                  <p class="card-text d-flex justify-content-start mt-3 mb-0">
                    <span>Nomor Rekening</span>
                  </p>
                  <p class="card-text d-flex justify-content-between mb-0">
                    <strong id="bank_number">{{ $payment->bank->account_code }}</strong>
                    <a href="#" class="text-end copy-text" style="color: green">Salin <i
                        class="far fa-copy text-sm"></i></a>
                  </p>
                @endif
                <p class="card-text d-flex justify-content-between mt-3 mb-0">
                  <span>Total Bayar</span>
                </p>
                <p class="card-text d-flex justify-content-between mb-0">
                  <span>
                    <strong id="total_payment">Rp{{ number_format($payment->total_pay, 0, ',', '.') }}</strong>
                    <a href="#" style="color: green" class="copy-text"><i class="far fa-copy text-sm"></i></a>
                  </span>
                  <a href="#" id="detail-transcation" class="text-end" style="color: green" data-toggle="modal"
                    data-target="#detail-transaction-modal">Detail Pembayaran</a>
                </p>
              </div>
              <div class="card-footer text-muted">
                <div class="container-fluid justify-content-center">
                  <div class="row w-100 mb-2 mt-2">
                    <div class="col-4 pr-1">
                      @if ($payment->payment == 'pick-up-order' || $payment->payment == 'cash-on-delivery')
                        <form action="{{ route('public.cancelled.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="payment_id" value="{{ $payment->id_payment }}">
                          <button type="submit" class="btn btn-danger btn-block btn-sm text-center"
                            onclick="return confirm('Apakah anda ingin membatalkan pesanan?')">
                            Batalkan Pesanan
                          </button>
                        </form>
                      @else
                        <a href="#" class="btn btn-login btn-block btn-sm text-center" data-toggle="modal"
                          data-target="#confirm-user" data-payment-id="{{ $payment->id }}">Konfirmasi</a>
                      @endif
                    </div>
                    <div class="col-4 pl-1">
                      <form action="{{ route('public.cancelled.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_id" value="{{ $payment->id_payment }}">
                        <button type="submit" class="btn btn-danger btn-block btn-sm text-center"
                          onclick="return confirm('Apakah anda ingin membatalkan pesanan?')">
                          Batalkan Pesanan
                        </button>
                      </form>
                    </div>
                    <div class="col-4 pl-1">
                      <a href="#" class="btn btn-outline-login btn-block btn-sm text-center ">Kembali</a>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="detail-transaction-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <strong>Total Belanja</strong>
          <p class="d-flex justify-content-between mb-0">
            <span>Total Harga ({{ $payment->total_item }}) Barang</span>
            <span id="total-item-price" class="text-end">
              {{ number_format($payment->total_price_item, 0, ',', '.') }}
            </span>
          </p>
          <p class="d-flex justify-content-between mb-0">
            <span>Total Ongkos Kirim</span>
            <span id="total-item-price" class="text-end">
              {{ number_format($payment->total_fee_shipping, 0, ',', '.') }}
            </span>
          </p>
          <p class="d-flex justify-content-between">
            <span>Total Charge Package</span>
            <span id="total-item-price" class="text-end">
              {{ number_format($payment->total_fee_package, 0, ',', '.') }}
            </span>
          </p>


          <p class="d-flex justify-content-between mt-3">
            <strong>Total Bayar</strong>
            <strong id="total-item-price" class="text-end">
              {{ number_format($payment->total_pay, 0, ',', '.') }}
            </strong>
          </p>


          <strong>Dibayar Dengan</strong>
          <p class="d-flex justify-content-between mt-0 mb-3">
            @if (!empty($payment->bank))
              <span class="text-muted">{{ $payment->bank->bank_name }}</span>
              <span id="total-item-price" class="text-muted text-end">
                {{ number_format($payment->total_pay, 0, ',', '.') }}
              </span>
            @else
              <span class="text-muted">{{ str_replace("'", '"', ucwords($payment->payment)) }}</span>
              <span id="total-item-price" class="text-muted text-end">
                {{ number_format($payment->total_pay, 0, ',', '.') }}
              </span>
            @endif
          </p>

          <strong>Barang yang kamu pilih</strong>
          @foreach ($listItem as $item)
            <p class="d-flex justify-content-between mb-0">
              <strong>{{ $item->product->title }}</strong>
              <span id="total-item-price" class="text-muted text-end">
                {{ number_format($item->total_price, 0, ',', '.') }}
              </span>
            </p>
            <span class="text-muted mb-0">Jumlah {{ $item->quantity }} x {{ $item->product->display_price }}</span>

            <p class="d-flex justify-content-between mb-3">
              <span class="text-muted">Ongkos Kirim</span>
              <span id="total-item-price" class="text-muted text-end">
                {{ number_format($item->paid->total_fee_shipping, 0, ',', '.') }}
              </span>
            </p>

            <hr>
          @endforeach

          @if ($payment->bank)
            <strong>Alamat Pengiriman</strong>
            <p class="text-muted">{{ $payment->shipping->address }}</p>
          @endif


        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="confirm-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('public.payment.update', $payment->id_payment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name">Nama Akun <span style="color: red">*</span></label>
              <input type="text" name="paid_name" class="form-control" placeholder="Masukkan Nama Rekening"
                value="{{ $payment->paid_name }}" required>
            </div>
            <div class="form-group">
              <label for="codeBank">Kode Bank <span style="color: red">*</span></label>
              <input type="text" name="paid_code_bank" class="form-control"
                placeholder="Masukkan Kode Bank. Misal: 008" value="{{ $payment->paid_code_bank }}" required>
            </div>
            <div class="form-group">
              <label for="codeAccount">Nomor Rekening <span style="color: red">*</span></label>
              <input type="text" name="paid_number_bank" class="form-control" placeholder="Masukkan Nomor Rekening"
                value="{{ $payment->paid_number_bank }}" required>
            </div>
            <div class="form-group">
              <label for="proofLink">Masukkan Link Pembayaran (Gunakan <a href="https://prnt.sc/">prnt.sc</a>) <span
                  style="color: red">*</span></label>
              <input type="text" name="paid_proof_link" class="form-control"
                placeholder="Masukkan Link Bukti Pembayaran. Gunakan prnt.sc" value="{{ $payment->paid_proof_link }}"
                required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Lanjutkan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script>
    console.log('{{ $payment->id_payment }}');
    const countdownElement = document.getElementById('countdown');

    function updateCountdown() {
      const expiredAt = new Date('{{ $payment->expired_at }}');
      const now = new Date();
      const diffTime = expiredAt - now;

      if (diffTime <= 0) {
        countdownElement.innerHTML = 'Waktu habis';
        clearInterval(countdownInterval); // Stop the timer
        // Add logic for expired payment here (e.g., redirect, display message)
        return;
      }

      const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
      const diffHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const diffMinutes = Math.floor((diffTime % (1000 * 60 * 60)) / (1000 * 60));
      const diffSeconds = Math.ceil((diffTime % (1000 * 60)) / 1000);

      let countdownText = '';

      if (diffDays > 0) {
        countdownText += diffDays + ' hari ';
      }

      if (diffHours > 0) {
        countdownText += diffHours + ' jam ';
      }

      if (diffMinutes > 0) {
        countdownText += diffMinutes + ' menit ';
      }

      countdownText += diffSeconds + ' detik';

      if ('{{ $payment->bank }}') {
        countdownElement.innerHTML = countdownText;
      }
    }

    updateCountdown(); // Initial update
    const countdownInterval = setInterval(updateCountdown, 1000); // Update every second

    document.querySelectorAll('.copy-text').forEach(function(copyButton) {
      copyButton.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior

        // Determine which element's text to copy
        const targetId = this.previousElementSibling.id; // Get the id of the previous sibling element
        const textToCopy = document.getElementById(targetId).textContent;

        // Create a temporary text area
        const tempTextArea = document.createElement('textarea');
        tempTextArea.value = textToCopy;
        document.body.appendChild(tempTextArea);
        tempTextArea.select();
        document.execCommand('copy');
        document.body.removeChild(tempTextArea);

        // Optional: Show a success message or notification
        alert(`${textToCopy} copied to clipboard!`);
      });
    });
  </script>
@endsection
