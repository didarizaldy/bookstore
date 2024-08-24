@extends('layouts.public.app')

@section('titlebar')
  Keranjang
@endsection

@section('content-header')
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><strong>Keranjang</strong></li>
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
              <div class="row">
                <div class="col-6">
                  <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="select-all">
                    <label class="custom-control-label" for="select-all">Pilih semua</label>
                  </div>
                </div>
                <div class="col-6 text-right">
                  <a href="#" id="delete-all" class="text-danger">Hapus</a>
                </div>
              </div>
            </div>
          </div>

          <div id="empty-cart-section" class="card w-100" style="display: none;">
            <div class="card-body">
              <h5 class="card-title">Wah Kosong nih</h5>
              <p class="card-text">Kamu belum memasukkan apapun ke dalam keranjangmu.</p>
            </div>
          </div>


          @if (!$cartItems->isEmpty())
            @foreach ($cartItems as $item)
              <div class="card w-100 cart-item">
                <div class="card-body border-bottom">
                  <div class="row align-items-center">
                    <div class="col-1">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input item-checkbox"
                          id="item-{{ $item->product->id }}" data-id="{{ $item->product->id }}"
                          data-price="{{ $item->product->display_price }}" data-quantity="{{ $item->quantity }}">
                        <label class="custom-control-label" for="item-{{ $item->product->id }}"></label>
                      </div>
                    </div>
                    <div class="col-2">
                      <img src="{{ asset('assets/img/cover-book/' . $item->product->filename_img) }}"
                        alt="{{ $item->product->title }}" class="img-fluid">
                    </div>
                    <div class="col-5">
                      <p>{{ $item->product->title }}</p>
                    </div>
                    <div class="col-4 text-right">
                      <p>
                        @if ($item->product->discount > 0)
                          <small
                            class="text-muted"><del>Rp{{ number_format($item->product->original_price, 0, ',', '.') }}</del></small>
                          <strong
                            id="price-{{ $item->product->id }}">Rp{{ number_format($item->product->display_price * $item->quantity, 0, ',', '.') }}</strong>
                        @else
                          <strong
                            id="price-{{ $item->product->id }}">Rp{{ number_format($item->product->display_price * $item->quantity, 0, ',', '.') }}</strong>
                        @endif
                      </p>
                      <div class="input-group input-group-sm w-75 float-right mb-2">
                        <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus"
                            data-id="{{ $item->product->id }}">
                            <span><small><i class="fas fa-minus" style="color: #0EB3FF"></i></small></span>
                          </button>
                        </span>
                        <input type="text" id="quantity-{{ $item->product->id }}" name="quantity"
                          class="form-control input-number" value="{{ $item->quantity }}" min="1"
                          max="{{ $item->product->stocks }}" data-price="{{ $item->product->display_price }}" readonly>
                        <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus"
                            data-id="{{ $item->product->id }}">
                            <span><small><i class="fas fa-plus" style="color: #0EB3FF"></i></small></span>
                          </button>
                        </span>
                      </div>
                      <button type="button" class="btn btn-danger btn-sm delete-item"
                        data-id="{{ $item->product->id }}">Hapus</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
          <div class="card w-100">
            <div class="card-body">
              <h5 class="card-title"><strong>Ringkasan Belanja</strong></h5>
              <p class="card-text d-flex justify-content-between">
                <span>Total</span>
                <strong id="total-price" class="text-end">
                  Rp{{ number_format($cartItems->sum(fn($item) => $item->product->display_price * $item->quantity), 0, ',', '.') }}
                </strong>
              </p>
              <form id="purchase-form" action="{{ route('public.cart.save') }}" method="POST">
                @csrf
                <input type="hidden" name="selectedItems" id="selected-items">
                <button type="submit" class="btn btn-success btn-block" style="border-radius: 12px">Beli</button>
              </form>
            </div>
          </div>
        </div>

      </div>

    </div>
    </div>
  </section>
@endsection

@section('javascript')
  <script>
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceElement = document.getElementById('total-price');
    const emptyCartSection = document.getElementById('empty-cart-section');


    function updateTotalPrice() {
      let totalPrice = 0;
      const checkedItems = document.querySelectorAll('.item-checkbox:checked');
      checkedItems.forEach(function(checkbox) {
        const price = parseFloat(checkbox.dataset.price);
        const quantity = parseInt(checkbox.dataset.quantity);
        totalPrice += price * quantity;
      });
      totalPriceElement.innerText = `Rp${totalPrice.toLocaleString('id-ID')}`;
    }

    function isCartEmpty() {
      const itemCards = document.querySelectorAll('.cart-item');
      return itemCards.length === 0;
    }

    document.addEventListener('cartIsEmpty', function() {
      if (emptyCartSection) {
        emptyCartSection.style.display = 'block';
      }
    });



    document.addEventListener('DOMContentLoaded', function() {
      selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(function(checkbox) {
          checkbox.checked = selectAllCheckbox.checked;
        });
        updateTotalPrice();
      });

      itemCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', updateTotalPrice);
      });

      updateTotalPrice(); // Initial calculation

      if (emptyCartSection) {
        if (isCartEmpty()) {
          emptyCartSection.style.display = 'block';
        }
      }
    });

    function updateNavbarCartCount(count) {
      const navbarBadge = document.querySelector('.navbar-badge');
      navbarBadge.innerText = count;
    }

    document.getElementById('delete-all').addEventListener('click', function(event) {
      event.preventDefault();

      console.log('Delete All clicked'); // Check if the event is triggered

      const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(checkbox => checkbox
        .getAttribute('data-id'));
      console.log('Selected Items:', selectedItems);

      if (selectedItems.length === 0) {
        console.error('No items selected');
        return;
      }

      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('{{ route('public.cart.delete.selected') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
              },
              body: JSON.stringify({
                selectedItems: selectedItems,
                _token: '{{ csrf_token() }}' // Include CSRF token in the request body
              })
            })
            .then(response => response.json())
            .then(response => {
              selectedItems.forEach(id => {
                const checkbox = document.querySelector(`input[type="checkbox"][data-id="${id}"]`);
                console.log(`Processing item with ID: ${id}`);
                if (checkbox) {
                  const itemCard = checkbox.closest('.card');
                  if (itemCard) {
                    console.log(`Removing card for item ID: ${id}`);
                    itemCard.remove();

                    if (isCartEmpty()) {
                      document.dispatchEvent(new Event('cartIsEmpty'));
                    }
                  } else {
                    console.error('Card not found for checkbox', checkbox);
                  }
                } else {
                  console.error(`No checkbox found for item-${id}`);
                }
              });

              updateTotalPrice();
              updateNavbarCartCount(response.newCartCount); // Update navbar cart count
            })
            .catch(error => {
              console.error(error);
              Swal.fire({
                icon: 'error',
                title: 'Failed to delete items'
              });
            });
        }
      });
    });



    document.querySelectorAll('.quantity-right-plus, .quantity-left-minus').forEach(function(button) {
      button.addEventListener('click', function() {
        const itemId = this.dataset.id;
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let currentQuantity = parseInt(quantityInput.value);
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));
        const pricePerItem = parseFloat(quantityInput.dataset.price);

        if (this.dataset.type === 'plus' && currentQuantity < maxQuantity) {
          currentQuantity++;
        } else if (this.dataset.type === 'minus' && currentQuantity > 1) {
          currentQuantity--;
        }

        quantityInput.value = currentQuantity;

        const priceElement = document.getElementById(`price-${itemId}`);
        priceElement.innerText = `Rp${(currentQuantity * pricePerItem).toLocaleString('id-ID')}`;

        // Update the price in the checkbox dataset as well
        const itemCheckbox = document.getElementById(`item-${itemId}`);
        itemCheckbox.dataset.quantity = currentQuantity;

        updateTotalPrice();
      });
    });


    document.querySelectorAll('.delete-item').forEach(function(button) {
      button.addEventListener('click', function() {
        const itemId = this.dataset.id;
        const itemCard = this.closest('.card');

        fetch(`{{ url('/keranjang/hapus-item') }}/${itemId}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
            },
            body: JSON.stringify({
              _token: '{{ csrf_token() }}' // Include CSRF token in the request body
            })
          })
          .then(response => response.json())
          .then(response => {
            itemCard.remove();
            updateNavbarCartCount(response.newCartCount);
            updateTotalPrice();

            if (isCartEmpty()) {
              document.dispatchEvent(new Event('cartIsEmpty'));
            }
          })
          .catch(error => {
            console.error(error);
            // Optionally show an error message
          });
      });
    });

    document.getElementById('purchase-form').addEventListener('submit', function(event) {
      var selectedItemsArray = [];

      document.querySelectorAll('.item-checkbox:checked').forEach(function(checkbox) {
        selectedItemsArray.push(checkbox.dataset.id); // Assuming the value of each checkbox is the item ID
      });

      if (selectedItemsArray.length === 0) {
        event.preventDefault();
        alert('Please select at least one item to purchase.');
      } else {
        document.getElementById('selected-items').value = JSON.stringify(selectedItemsArray);
      }
    });
  </script>
@endsection
