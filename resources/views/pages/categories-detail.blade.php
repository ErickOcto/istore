@extends('layouts.app')

@section('title')
    Categories Detail
@endsection
@section('content')

@php
    $countProduct = DB::table('products')->where('category_id', $category->id)->where('deleted_at', NULL)->count();
@endphp

<div class="page-content page-categories">
      <section class="store-trend-categories">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>All Categories</h5>
            </div>
          </div>
          <div class="row">

                @forelse ($categories as $item)
                @php
                    {{ $perulanganAos = 0; }}
                @endphp
                <div
                      class="col-6 col-md-3 col-lg-2"
                      data-aos="fade-up"
                      data-aos-delay="{{ $perulanganAos += 100; }}"
                    >
                      <a class="component-categories d-block" href="{{ route('categories-detail', $item->slug) }}">
                        <div class="categories-image">
                          <img
                            src="{{ Storage::url($item->photo) }}"
                            alt="{{ $item->slug }}"
                            class="w-100"
                          />
                        </div>
                        <p class="categories-text">
                          {{ $item->name }}
                        </p>
                      </a>
                </div>

                @empty

                <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                No Category Found
            </div>

            @endforelse

          </div>
        </div>
      </section>

    <div class="col-12">
        @if($products->count() > 0)
            <h6 class="text-center my-5">Showing {{ $countProduct }} Product In {{ $category->name }} Category</h6>
        @endif

    <section class="store-new-products">
        <div class="container">
          <div class="row">

            @forelse ($products as $product)
            @php
                {{ $perulanganAos = 0; }}
            @endphp
            <div
              class="col-6 col-md-4 col-lg-3"
              data-aos="fade-up"
              data-aos-delay="{{ $perulanganAos += 100 }}"
            >
              <a class="component-products d-block" href="{{ route('detail', $product->slug) }}">
                <div class="products-thumbnail">
                  <div
                    class="products-image"
                    style="
                    @if($product->galleries->first())
                      background-image: url('{{ Storage::url($product->galleries->first()->photo) ?? '/images/pnf.jpeg'}}');
                    @else
                        background-image: url('{{ '/images/pnf.jpeg' }}');
                    @endif
                    "
                  ></div>
                </div>
                <div class="products-text">
                  {{ $product->name }}
                </div>
                <div class="products-price">
                  {{ $product->price }}
                </div>
              </a>
            </div>
            @empty

            <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                No Product Found
            </div>

            @endforelse
          </div>
          <div class="row">
            <div class="col-12 mt-4">
                {{ $products->links() }}
            </div>
          </div>
        </div>
      </section>
    </div>
</div>
@endsection
