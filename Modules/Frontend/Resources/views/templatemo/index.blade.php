@extends('frontend::templatemo.layout')

@section('title', 'Zay Shop eCommerce')

@section('content')
    <!-- Start Banner Hero (Advertisements Carousel) -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators" id="ads-indicators"></div>

        <div class="carousel-inner" id="ads-carousel-inner">
            <!-- Ads slides will be loaded dynamically -->
        </div>

        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <!-- End Banner Hero -->

    <!-- Start Categories of The Month -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Categories of The Month</h1>
                <p>
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
        <div class="row" id="categories-container"></div>
    </section>
    <!-- End Categories of The Month -->

    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Featured Product</h1>
                    <p>
                        Reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        Excepteur sint occaecat cupidatat non proident.
                    </p>
                </div>
            </div>
            <div class="row" id="featured-products-container"></div>
        </div>
    </section>
    <!-- End Featured Product -->
@endsection

@push('js')
<script>
    $(document).ready(function () {
        loadAdvertisements();
        loadFeaturedProducts();
        loadCategories();
    });

    const FALLBACK_BANNER_1 = "{{ asset('templatemo_559_zay_shop/assets/img/banner_img_01.jpg') }}";
    const FALLBACK_BANNER_2 = "{{ asset('templatemo_559_zay_shop/assets/img/banner_img_02.jpg') }}";
    const FALLBACK_BANNER_3 = "{{ asset('templatemo_559_zay_shop/assets/img/banner_img_03.jpg') }}";

    const FEATURE_FALLBACK_IMAGE = "{{ asset('templatemo_559_zay_shop/assets/img/feature_prod_01.jpg') }}";

    const CATEGORY_IMG_BASE = "{{ asset('templatemo_559_zay_shop/assets/img') }}";
    const SHOP_URL = "{{ route('frontend.shop') }}";

    // عدّل المسار ده لو عندك route مختلف للفيندر
    const VENDOR_URL_BASE = "{{ url('/vendor') }}";

   function loadAdvertisements() {
    $.ajax({
        url: window.API_BASE_URL + '/advertisements',
        method: 'GET',
        dataType: 'json',
        headers: { 'Accept': 'application/json' },
        success: function (response) {
            console.log('ADS RAW RESPONSE:', response);

            // يقبل success = true أو 1 أو "true"
            const ok = response && (response.success === true || response.success === 1 || response.success === "true");

            // يقبل data array أو data.data (pagination)
            let ads = [];
            if (ok) {
                if (Array.isArray(response.data)) ads = response.data;
                else if (response.data && Array.isArray(response.data.data)) ads = response.data.data;
            }

            if (!ads.length) {
                console.warn('No ads parsed. Response shape is not expected:', response);
                renderFallbackBanners();
                return;
            }

            let indicatorsHtml = '';
            let slidesHtml = '';

            ads.forEach((ad, index) => {
                const activeClass = index === 0 ? 'active' : '';
                const image = ad.image || FALLBACK_BANNER_1;
                const title = ad.title || '';
                const description = ad.description || '';
                const link = ad.vendor_id ? `${VENDOR_URL_BASE}/${ad.vendor_id}` : '#';

                indicatorsHtml += `
                    <button type="button"
                            data-bs-target="#template-mo-zay-hero-carousel"
                            data-bs-slide-to="${index}"
                            class="${activeClass}"
                            ${index === 0 ? 'aria-current="true"' : ''}
                            aria-label="Slide ${index + 1}">
                    </button>
                `;

                slidesHtml += `
                    <div class="carousel-item ${activeClass}">
                        <div class="container">
                            <div class="row p-5">
                                <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                    <a href="${link}">
                                        <img class="img-fluid" src="${image}" alt="${title}">
                                    </a>
                                </div>
                                <div class="col-lg-6 mb-0 d-flex align-items-center">
                                    <div class="text-align-left align-self-center">
                                        <h1 class="h1 text-success">${title}</h1>
                                        <p>${description}</p>
                                        ${ad.isVendorExists ? `<a class="btn btn-success mt-2" href="${link}">عرض المتجر</a>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#ads-indicators').html(indicatorsHtml);
            $('#ads-carousel-inner').html(slidesHtml);
        },
        error: function (xhr) {
            console.error('ADS AJAX ERROR:', xhr.status);
            console.log('ADS RESPONSE TEXT:', xhr.responseText);

            renderFallbackBanners();
        }
    });
}

    function renderFallbackBanners() {
        $('#ads-indicators').html(`
            <button type="button" data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        `);

        $('#ads-carousel-inner').html(`
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="${FALLBACK_BANNER_1}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Zay</b> eCommerce</h1>
                                <h3 class="h2">Tiny and Perfect eCommerce Template</h3>
                                <p>Fallback banner (no ads found).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="${FALLBACK_BANNER_2}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">Proident occaecat</h1>
                                <h3 class="h2">Aliquip ex ea commodo consequat</h3>
                                <p>Fallback banner (no ads found).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="${FALLBACK_BANNER_3}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">Repr in voluptate</h1>
                                <h3 class="h2">Ullamco laboris nisi ut</h3>
                                <p>Fallback banner (no ads found).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    function loadFeaturedProducts() {
        $.ajax({
            url: window.API_BASE_URL + '/products',
            method: 'GET',
            data: { limit: 3 },
            success: function (response) {
                console.log('PRODUCTS RESPONSE:', response);

                if (response && response.success && response.data) {
                    const products = response.data.data || response.data;
                    let html = '';

                    products.slice(0, 3).forEach(function (product) {
                        const image = product.media && product.media.length > 0
                            ? (product.media[0].original_url || FEATURE_FALLBACK_IMAGE)
                            : FEATURE_FALLBACK_IMAGE;

                        const price = product.price || '0.00';
                        const name = product.name || 'Product';
                        const description = product.description || 'Product description';

                        html += `
                            <div class="col-12 col-md-4 mb-4">
                                <div class="card h-100">
                                    <a href="/shop/${product.id}">
                                        <img src="${image}" class="card-img-top" alt="${name}">
                                    </a>
                                    <div class="card-body">
                                        <ul class="list-unstyled d-flex justify-content-between">
                                            <li>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-muted fa fa-star"></i>
                                                <i class="text-muted fa fa-star"></i>
                                            </li>
                                            <li class="text-muted text-right">$${price}</li>
                                        </ul>
                                        <a href="/shop/${product.id}" class="h2 text-decoration-none text-dark">${name}</a>
                                        <p class="card-text">${(description || '').toString().substring(0, 100)}...</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#featured-products-container').html(html);
                }
            },
            error: function (xhr) {
                console.error('Error loading products:', xhr);
            }
        });
    }

    function loadCategories() {
        const categories = [
            { name: 'Watches', image: 'category_img_01.jpg' },
            { name: 'Shoes', image: 'category_img_02.jpg' },
            { name: 'Accessories', image: 'category_img_03.jpg' }
        ];

        let html = '';
        categories.forEach(function (category) {
            const img = `${CATEGORY_IMG_BASE}/${category.image}`;

            html += `
                <div class="col-12 col-md-4 p-5 mt-3">
                    <a href="${SHOP_URL}">
                        <img src="${img}" class="rounded-circle img-fluid border" alt="${category.name}">
                    </a>
                    <h5 class="text-center mt-3 mb-3">${category.name}</h5>
                    <p class="text-center">
                        <a class="btn btn-success" href="${SHOP_URL}">Go Shop</a>
                    </p>
                </div>
            `;
        });

        $('#categories-container').html(html);
    }
</script>
@endpush
