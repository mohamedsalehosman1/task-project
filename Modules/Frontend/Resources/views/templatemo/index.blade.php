@extends('frontend::templatemo.layout')

@section('title', 'Zay Shop eCommerce')

@section('content')
    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{ asset('templatemo_559_zay_shop/assets/img/banner_img_01.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Zay</b> eCommerce</h1>
                                <h3 class="h2">Tiny and Perfect eCommerce Template</h3>
                                <p>
                                    Zay Shop is an eCommerce HTML5 CSS template with latest version of Bootstrap 5 (beta 1).
                                    This template is 100% free provided by <a rel="sponsored" class="text-success" href="https://templatemo.com" target="_blank">TemplateMo</a> website.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{ asset('templatemo_559_zay_shop/assets/img/banner_img_02.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">Proident occaecat</h1>
                                <h3 class="h2">Aliquip ex ea commodo consequat</h3>
                                <p>
                                    You are permitted to use this Zay CSS template for your commercial websites.
                                    You are <strong>not permitted</strong> to re-distribute the template ZIP file in any kind of template collection websites.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{ asset('templatemo_559_zay_shop/assets/img/banner_img_03.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">Repr in voluptate</h1>
                                <h3 class="h2">Ullamco laboris nisi ut </h3>
                                <p>
                                    We bring you 100% free CSS templates for your websites.
                                    If you wish to support TemplateMo, please make a small contribution via PayPal or tell your friends about our website. Thank you.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="row" id="categories-container">
            <!-- Categories will be loaded dynamically -->
        </div>
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
            <div class="row" id="featured-products-container">
                <!-- Products will be loaded dynamically -->
            </div>
        </div>
    </section>
    <!-- End Featured Product -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Load featured products
        loadFeaturedProducts();
        loadCategories();
    });

    function loadFeaturedProducts() {
        $.ajax({
            url: API_BASE_URL + '/products',
            method: 'GET',
            data: { limit: 3 },
            success: function(response) {
                if (response.success && response.data) {
                    const products = response.data.data || response.data;
                    let html = '';

                    products.slice(0, 3).forEach(function(product) {
                        const image = product.media && product.media.length > 0
                            ? product.media[0].original_url
                            : '{{ asset("templatemo_559_zay_shop/assets/img/feature_prod_01.jpg") }}';
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
                                        <p class="card-text">${description.substring(0, 100)}...</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#featured-products-container').html(html);
                }
            },
            error: function(xhr) {
                console.error('Error loading products:', xhr);
            }
        });
    }

    function loadCategories() {
        // Load categories if you have a categories API endpoint
        // For now, using static categories
        const categories = [
            { name: 'Watches', image: 'category_img_01.jpg' },
            { name: 'Shoes', image: 'category_img_02.jpg' },
            { name: 'Accessories', image: 'category_img_03.jpg' }
        ];

        let html = '';
        categories.forEach(function(category) {
            html += `
                <div class="col-12 col-md-4 p-5 mt-3">
                    <a href="{{ route('frontend.shop') }}"><img src="{{ asset('templatemo_559_zay_shop/assets/img/${category.image}') }}" class="rounded-circle img-fluid border"></a>
                    <h5 class="text-center mt-3 mb-3">${category.name}</h5>
                    <p class="text-center"><a class="btn btn-success" href="{{ route('frontend.shop') }}">Go Shop</a></p>
                </div>
            `;
        });

        $('#categories-container').html(html);
    }
</script>
@endpush

