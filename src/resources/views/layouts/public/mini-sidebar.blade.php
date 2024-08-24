<div class="card w-100">
  <div class="card-body box-profile">
    <h3 class="profile-username text-center">{{ Auth::user()->fullname }}</h3>
    <p class="text-muted text-center">{{ Auth::user()->email }}</p>
  </div>
</div>


<div class="card w-100">

  <div id="accordion">
    <div class="card card-light">
      <div class="card-header">
        <h4 class="card-title w-100">
          <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
            Pembelian
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
          <ul class="list-group">
            <a href="{{ route('public.payment.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Menunggu Pembayaran
              </li>
            </a>
            <a href="{{ route('public.purchase.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Pembelian
              </li>
            </a>
          </ul>
        </div>
      </div>
    </div>
    <div class="card card-light">
      <div class="card-header">
        <h4 class="card-title w-100">
          <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
            Transaksi
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="collapse show" data-parent="#accordion">
        <div class="card-body">
          <ul class="list-group">
            <a href="{{ route('public.confirmation.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Menunggu Konfirmasi
              </li>
            </a>
            <a href="{{ route('public.processed.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Pesanan Diproses
              </li>
            </a>
            <a href="{{ route('public.delivery.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Sedang Dikirim
              </li>
            </a>
            <a href="{{ route('public.delivery.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Sampai Tujuan
              </li>
            </a>
            <a href="{{ route('public.cancelled.view') }}">
              <li class="list-group-item-light d-flex justify-content-between align-items-center">
                Dibatalkan
              </li>
            </a>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>
