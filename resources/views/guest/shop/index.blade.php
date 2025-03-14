@extends('layouts.app')
@section('content')

    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                                {{__('shop.categories')}}
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                    <li class="list-item">
                                        <span class="menu-link py-1">
                                            <input type="checkbox" name="categories" value="{{ $category->id }}" class="chk-category"
                                                {{ in_array($category->id, explode(',', $filters['categories'] ?? '')) ? 'checked' : '' }}>
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-right float-end">
                                            {{ $category->products_count }}
                                        </span>
                                    </li>
                                    @endforeach
                                </ul>
                                <button id="reset-categories" class="btn btn-sm btn-outline-secondary mt-2">{{__('shop.reset')}}</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="color-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
                                {{__('shop.color')}}
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                                    <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-size" aria-expanded="true" aria-controls="accordion-filter-size">
                                {{__('shop.sizes')}}
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XS</a>
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
                                    <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XXL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                                {{__('shop.brands')}}
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach($brands as $brand)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{ $brand->id }}" class="chk-brand"
                                                    {{ in_array($brand->id, explode(',', $filters['brands'] ?? '')) ? 'checked' : '' }}>
                                                {{ $brand->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ $brand->products_count }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                                <button id="reset-brands" class="btn btn-sm btn-outline-secondary mt-2">{{__('shop.reset')}}</button>
                            </div>
                            </div>
                    </div>
                </div>


                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4">
                        <h5 class="accordion-header mb-2" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                                {{__('shop.price')}}
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="1"
                                   data-slider-max="700" data-slider-step="5" data-slider-value="[{{$filters['min']}},{{$filters['max']}}]" data-currency="$" />
                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">{{__('shop.minPrice')}}: </span>
                                    <span class="price-range__min">$1</span>
                                </div>
                                <div>
                                    <span class="text-secondary">{{__('shop.maxPrice')}}: </span>
                                    <span class="price-range__max">$700</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-list flex-grow-1">
                <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Women's <br /><strong>ACCESSORIES</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                            update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <div class="placeholder-image d-flex align-items-center justify-content-center"
                                             style="width: 630px; height: 450px; background-color: #1E1D2A; color: #f5f5f5; text-align: center;">
                                            <div>
                                                <p class="mb-0 fs-4">Placeholder Image</p>
                                                <p class="mb-0">630 × 450</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Women's <br /><strong>ACCESSORIES</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                            update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <div class="placeholder-image d-flex align-items-center justify-content-center"
                                             style="width: 630px; height: 450px; background-color: #1E1D2A; color: #f5f5f5; text-align: center;">
                                            <div>
                                                <p class="mb-0 fs-4">Placeholder Image</p>
                                                <p class="mb-0">630 × 450</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Women's <br /><strong>ACCESSORIES</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                            update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <div class="placeholder-image d-flex align-items-center justify-content-center"
                                             style="width: 630px; height: 450px; background-color: #1E1D2A; color: #f5f5f5; text-align: center;">
                                            <div>
                                                <p class="mb-0 fs-4">Placeholder Image</p>
                                                <p class="mb-0">630 × 450</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container p-3 p-xl-5">
                        <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

                    </div>
                </div>

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">{{__('shop.home')}}</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">{{__('shop.shop')}}</a>
                    </div>

                    <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1 ">
                        <x-partials.select
                            name="pagesize"
                            id="pageSize"
                            ariaLabel="Page Size"
                            :options="[
                                '' => 'Show',
                                '12' => __('shop.items',['item' => 12]),
                                '24' => __('shop.items',['item' => 24]),
                                '48' => __('shop.items',['item' => 48]),
                                '102' => __('shop.items',['item' => 102]),
                            ]"
                            :selected="$filters['size']"
                            class="me-1"
                        />

                        <x-partials.select
                            name="orderby"
                            id="orderby"
                            ariaLabel="Sort Items"
                            :options="[
                                'DESC' => __('shop.default'),
                                'newest' => __('shop.newest'),
                                'oldest' => __('shop.oldest'),
                                'lowToHigh' => __('shop.lowToHigh'),
                                'highToLow' => __('shop.highToLow'),
                                'aToZ' => __('shop.aToZ'),
                                'zToA' => __('shop.zToA'),
                                'discount' => __('shop.discount'),
                            ]"
                            :selected="$filters['order']"
                            class=""
                        />

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">{{__('shop.view')}}</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">{{__('filter')}}</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @if($products->isEmpty())
                        <div class="col-12 text-center py-5">
                            <div class="no-products-message">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-4 text-muted">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="8" y1="15" x2="16" y2="15"></line>
                                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                </svg>
                                <h3 class="mb-3">{{__('shop.noProductsFoundHeader')}}</h3>
                                <p class="text-muted mb-4">{{__('shop.noProductsFoundText')}}</p>
                                <a href="{{ route('home.index') }}" class="btn btn-primary rounded-1">{{__('returnHome')}}</a>
                            </div>
                        </div>
                    @else
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    @endif
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$products->withQueryString()->links('pagination::bootstrap-5')}}
                </div>

            </div>
        </section>
    </main>


@endsection

<form action="{{ route('shop.index') }}" method="GET" id="filter-form">
    @csrf
    <input type="hidden" name="page" value="{{ $products->currentPage() }}">
    <input type="hidden" name="size" id="size" value="{{ $filters['size'] }}">
    <input type="hidden" name="order" id="order" value="{{ $filters['order'] }}">
    <input type="hidden" name="brands" id="hdnBrands" value="{{ $filters['brands'] }}">
    <input type="hidden" name="categories" id="hdnCategories" value="{{ $filters['categories'] }}">
    <input type="hidden" name="min" id="hdnMinPrice" value="{{ $filters['min'] }}">
    <input type="hidden" name="max" id="hdnMaxPrice" value="{{ $filters['max'] }}">
</form>
@push('scripts')
    <script>
        $(function(){
            $(".custom-select").change(function(){
                if ($(this).attr('name') === 'pagesize') {
                    $("#size").val($(this).val());
                }
                $("#filter-form").submit();
            });

            $("#orderby").change(function(){
                $("#order").val($(this).val());
                $("#filter-form").submit();
            });

            $("input[name='brands']").change(function(){
                var brands = $("input[name='brands']:checked").map(function(){
                    return $(this).val();
                }).get().join(',');
                $("#hdnBrands").val(brands);
                $("#filter-form").submit();
            });

            $("input[name='categories']").change(function(){
                var categories = $("input[name='categories']:checked").map(function(){
                    return $(this).val();
                }).get().join(',');
                $("#hdnCategories").val(categories);
                $("#filter-form").submit();
            });

            $('[name="price_range"]').on('slideStop', function(ev){
                    var min = $(this).val().split(',')[0];
                    var max = $(this).val().split(',')[1];
                $("#hdnMinPrice").val(min);
                $("#hdnMaxPrice").val(max);
                $("#filter-form").submit();
            });
        });

        $(document).on('click', '#reset-brands', function(e){
            e.preventDefault();
            $("input[name='brands']").prop('checked', false);
            $("#hdnBrands").val('');
            $("#filter-form").submit();
        });

        $(document).on('click', '#reset-categories', function(e){
            e.preventDefault();
            $("input[name='categories']").prop('checked', false);
            $("#hdnCategories").val('');
            $("#filter-form").submit();
        });
    </script>
@endpush


@push('styles')
    <style>
        .custom-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: transparent;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px 32px 8px 12px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-select:hover, .custom-select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .custom-select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #666;
        }

        .custom-select:hover + .custom-select-icon,
        .custom-select:focus + .custom-select-icon {
            color: #007bff;
        }

        .filled-heart{
            color: orange;
        }
    </style>
@endpush
