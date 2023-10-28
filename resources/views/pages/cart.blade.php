@extends('layouts.app')

@section('title')
 Your Cart
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Cart
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section class="store-cart">
        <div class="container">
          @if($carts->count() > 0)
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 table-responsive">
              <table
                class="table table-borderless table-cart"
                aria-describedby="Cart"
              >
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name &amp; Seller</th>
                    <th scope="col">Price</th>
                    <th scope="col">Menu</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0
                    @endphp
                    @forelse ($carts as $cart)
                <tr>
                    <td style="width: 25%;">
                        @if($cart->product->galleries->first()->photo ?? NULL)
                        <img
                        src="{{ Storage::url($cart->product->galleries->first()->photo) }}"
                        alt=""
                        class="cart-image"
                      />
                        @endif
                    </td>
                    <td style="width: 35%;">
                      <div class="product-title">{{ $cart->product->name }}</div>
                      <div class="product-subtitle">by {{ $cart->user->store_name }}</div>
                    </td>
                    <td style="width: 35%;">
                      <div class="product-title">Rp. {{ number_format($cart->product->price, 0, ',','.') }}</div>
                      <div class="product-subtitle">IDR</div>
                    </td>
                    <td style="width: 20%;">
                      <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-remove-cart" type="submit">Remove</button>
                      </form>
                    </td>
                  </tr>
                  @php
                      $totalPrice += $cart->product->price
                  @endphp
                  @empty
                  <div class="col-12">
                    <div class="text-center">
                      <div class="fs-1">No Product In Cart</div>
                    </div>
                  </div>
                    @endforelse
                </tbody>
              </table>
            </div>
          </div>
          <div class="bungkus">
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-4">Shipping Details</h2>
            </div>
          </div>
        <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
          @csrf
          <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_1">Address 1</label>
                <input
                  type="text"
                  class="form-control"
                  id="address_1"
                  aria-describedby="emailHelp"
                  name="address_1"
                  value="Setra Duta Cemara"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_2">Address 2</label>
                <input
                  type="text"
                  class="form-control"
                  id="address_2"
                  aria-describedby="emailHelp"
                  name="address_2"
                  value="Blok B2 No. 34"
                />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="provinces_id">Province</label>
                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                  <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                </select>
                <select name="" class="form-control" v-else id="">
                  <option value="" disabled selected>Tidak ada data provinsi</option> <!-- Tambahkan pesan jika tidak ada data -->
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="regencies_id">City</label>
                <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                  <option value="" disabled selected>Pilih Provinsi</option> <!-- Tambahkan opsi default -->
                  <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                </select>
                <select name="" class="form-control" v-else id="">
                  <option value="" disabled selected>Tidak ada data provinsi</option> <!-- Tambahkan pesan jika tidak ada data -->
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="zip_code">Postal Code</label>
                <input
                  type="text"
                  class="form-control"
                  id="zip_code"
                  name="zip_code"
                  value=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="country">Country</label>
                <input
                  type="text"
                  class="form-control"
                  id="country"
                  name="country"
                  value="Indonesia"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone_number">Mobile</label>
                <input
                  type="text"
                  class="form-control"
                  id="phone_number"
                  name="phone_number"
                  value="+628 2020 11111"
                />
              </div>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2>Payment Informations</h2>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col-4 col-md-2">
              <div class="product-title">Rp. 0</div>
              <div class="product-subtitle">Country Tax</div>
            </div>
            <div class="col-4 col-md-3">
              <div class="product-title">Rp. 0</div>
              <div class="product-subtitle">Product Insurance</div>
            </div>
            <div class="col-4 col-md-2">
              <div class="product-title">Rp. 0</div>
              <div class="product-subtitle">Shipping</div>
            </div>
            <div class="col-4 col-md-2">
              <div class="product-title text-success">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</div>
              <div class="product-subtitle">Total</div>
            </div>
            <div class="col-8 col-md-3">
              <button
                type="submit"
                class="btn btn-success mt-4 px-4 btn-block"
              >
                Checkout Now
              </button>
            </div>
          </div>
        </form>
            @else
            <div class="row" style="height: 60vh;">
              <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="text-center">
                  <h1 class="mb-5">No Product In Your Cart...</h1>
                  <a href="{{ route('home') }}" class="btn btn-success">Shop Now</a>
                </div>
              </div>
            </div>
        </div>
        @endif
        </div>
      </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: "#locations",
        mounted() {
            AOS.init();
            this.getProvincesData();
        },
        data: {
            provinces: null,
            regencies: null,
            provinces_id: null,
            regencies_id: null
        },
        methods: {
            getProvincesData() {
                var self = this;
                axios.get('{{ route('api-provinces') }}')
                .then(function(response){
                    self.provinces = response.data;
                })
            },
            getRegenciesData(){
                var self = this;
                axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                .then(function(response){
                    self.regencies = response.data;
                })
            },
        },
        watch: {
            provinces_id: function(val, oldVal){
                this.regencies_id = null;
                this.getRegenciesData();
            }
        }
      });
    </script>
    <script src="/script/navbar-scroll.js"></script>
@endpush
