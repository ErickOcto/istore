{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('layouts.auth')

@section('title')
Register Now
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-auth mt-5" id="register">
      <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4">
              <h2>
                Memulai untuk jual beli <br />
                dengan cara terbaru
              </h2>
              <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="form-group">
                  <label>Full Name</label>
                  <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    aria-describedby="nameHelp"
                    v-model="name"
                    autofocus
                    autocomplete="name"
                    name="name"
                    required
                  />
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input
                    type="email"
                    v-model="email"
                    @change="checkForEmailAvailability()"
                    class="form-control @error('email') is-invalid @enderror"
                    :class="{ 'is-invalid' : this.email_unavailable}"
                    aria-describedby="emailHelp"
                    name="email"
                    autocomplete="email"

                    required
                  />
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password"/>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                  <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control @error('password_confirm') is-invalid @enderror" required autocomplete="new-password"/>
                  @error('password_confirm')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                </div>
                <div class="form-group">
                  <label>Store</label>
                  <p class="text-muted">
                    Apakah anda juga ingin membuka toko?
                  </p>
                  <div
                    class="custom-control custom-radio custom-control-inline"
                  >
                    <input
                      class="custom-control-input"
                      type="radio"
                      name="is_store_open"
                      id="openStoreTrue"
                      v-model="is_store_open"
                      :value="true"
                    />
                    <label class="custom-control-label" for="openStoreTrue"
                      >Iya, boleh</label
                    >
                  </div>
                  <div
                    class="custom-control custom-radio custom-control-inline"
                  >
                    <input
                      class="custom-control-input"
                      type="radio"
                      name="is_store_open"
                      id="openStoreFalse"
                      v-model="is_store_open"
                      :value="false"
                    />
                    <label
                      makasih
                      class="custom-control-label"
                      for="openStoreFalse"
                      >Enggak, makasih</label
                    >
                  </div>
                </div>
                <div class="form-group" v-if="is_store_open">
                  <label>Nama Toko</label>
                  <input
                    type="text"
                    class="form-control @error('store_name') is-invalid @enderror"
                    aria-describedby="storeHelp"
                    v-model="store_name"
                    id="store_name"
                    name="store_name"
                    autofocus
                    autocomplete="store_name"
                  />
                  @error('store_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group" v-if="is_store_open">
                  <label>Kategori</label>
                  <select name="categories_id" class="form-control">
                    <option value="" selected>Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-success btn-block mt-4"
                :disabled="this.email_unavailable"
                >
                  Sign Up Now
                </button>
                <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">
                  Back to Sign In
                </a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
        },
        methods: {
            checkForEmailAvailability: function(){
                var self = this;
                axios.get('{{ route('api.register.check') }}', {
                    params: {
                        email: this.email;
                    }
                })
                    .then(function (response){
                        if(response.data == 'Available')
                              self.$toasted.show(
                                "Email yang anda input tersedia, Silahkan lanjutkan langkah selanjutnya",
                                {
                                  position: "top-center",
                                  className: "rounded",
                                  duration: 1000,
                                }
                              );
                              self.email_unavailable = false;

                        if(response.data == 'Unavailable')
                              self.$toasted.error(
                                "Maaf, tampaknya email sudah terdaftar pada sistem kami.",
                                {
                                  position: "top-center",
                                  className: "rounded",
                                  duration: 1000,
                                }
                              );
                              self.email_unavailable = true;

                            //   Handle Success
                            console.log(response);
                    })
            }
        },
        data() {
        return {
          name: "Input Your Name",
          email: "your@mail.store",
          email_unavailable: false
          is_store_open: true,
          store_name: "",
         }
        },
      });
    </script>
    <script src="/script/navbar-scroll.js"></script>
@endpush
