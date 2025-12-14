@extends('frontend::templatemo.layout')

@section('title', 'Zay Shop - Product Detail Page')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('templatemo_559_zay_shop/assets/css/slick.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('templatemo_559_zay_shop/assets/css/slick-theme.css') }}">
@endpush

@section('content')
    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row" id="product-detail-container">
                <!-- Product details will be loaded here -->
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Related Products</h4>
            </div>
            <div id="carousel-related-product">
                <!-- Related products will be loaded here -->
            </div>
        </div>
    </section>
    <!-- End Article -->
@endsection

@push('scripts')
<script src="{{ asset('templatemo_559_zay_shop/assets/js/slick.min.js') }}"></script>
<script>
    $(document).ready(function() {
        const productId = @json($productId ?? null);
        if (productId) {
            loadProductDetail(productId);
            loadRelatedProducts(productId);
        }
    });

    function loadProductDetail(productId) {
        $.ajax({
            url: API_BASE_URL + '/products/' + productId,
            method: 'GET',
            success: function(response) {
                if (response.success && response.data) {
                    const product = response.data;
                    const images = product.media && product.media.length > 0 
                        ? product.media 
                        : [{ original_url: '{{ asset("templatemo_559_zay_shop/assets/img/product_single_10.jpg") }}' }];
                    const mainImage = images[0].original_url;
                    
                    let imagesHtml = '';
                    images.forEach(function(img, index) {
                        imagesHtml += `
                            <div class="col-4">
                                <a href="#">
                                    <img class="card-img img-fluid" src="${img.original_url}" alt="Product Image ${index + 1}">
                                </a>
                            </div>
                        `;
                    });
                    
                    const html = `
                        <div class="col-lg-5 mt-5">
                            <div class="card mb-3">
                                <img class="card-img img-fluid" src="${mainImage}" alt="Card image cap" id="product-detail">
                            </div>
                            <div class="row">
                                <div class="col-1 align-self-center">
                                    <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                        <i class="text-dark fas fa-chevron-left"></i>
                                    </a>
                                </div>
                                <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                                    <div class="carousel-inner product-links-wap" role="listbox">
                                        <div class="carousel-item active">
                                            <div class="row">
                                                ${imagesHtml}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 align-self-center">
                                    <a href="#multi-item-example" role="button" data-bs-slide="next">
                                        <i class="text-dark fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="h2">${product.name || 'Product'}</h1>
                                    <p class="h3 py-2">$${product.price || '0.00'}</p>
                                    <p class="py-2">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <span class="list-inline-item text-dark">Rating ${product.rate || '4.8'}</span>
                                    </p>
                                    <h6>Description:</h6>
                                    <p>${product.description || 'Product description'}</p>
                                    <form action="" method="GET">
                                        <input type="hidden" name="product-id" value="${product.id}">
                                        <div class="row">
                                            <div class="col-auto">
                                                <ul class="list-inline pb-3">
                                                    <li class="list-inline-item">Size :
                                                        <input type="hidden" name="product-size" id="product-size" value="S">
                                                    </li>
                                                    <li class="list-inline-item"><span class="btn btn-success btn-size">S</span></li>
                                                    <li class="list-inline-item"><span class="btn btn-success btn-size">M</span></li>
                                                    <li class="list-inline-item"><span class="btn btn-success btn-size">L</span></li>
                                                    <li class="list-inline-item"><span class="btn btn-success btn-size">XL</span></li>
                                                </ul>
                                            </div>
                                            <div class="col-auto">
                                                <ul class="list-inline pb-3">
                                                    <li class="list-inline-item text-right">
                                                        Quantity
                                                        <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                                                    </li>
                                                    <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                                                    <li class="list-inline-item"><span class="badge bg-secondary" id="var-value">1</span></li>
                                                    <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row pb-3">
                                            <div class="col d-grid">
                                                <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Buy</button>
                                            </div>
                                            <div class="col d-grid">
                                                <button type="button" class="btn btn-success btn-lg add-to-cart-btn" data-product-id="${product.id}">Add To Cart</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#product-detail-container').html(html);
                }
            },
            error: function(xhr) {
                console.error('Error loading product:', xhr);
            }
        });
    }

    function loadRelatedProducts(productId) {
        $.ajax({
            url: API_BASE_URL + '/products',
            method: 'GET',
            data: { limit: 8, exclude: productId },
            success: function(response) {
                if (response.success && response.data) {
                    const products = response.data.data || response.data;
                    let html = '';
                    
                    products.forEach(function(product) {
                        const image = product.media && product.media.length > 0 
                            ? product.media[0].original_url 
                            : '{{ asset("templatemo_559_zay_shop/assets/img/shop_08.jpg") }}';
                        const price = product.price || '0.00';
                        const name = product.name || 'Product';
                        
                        html += `
                            <div class="p-2 pb-3">
                                <div class="product-wap card rounded-0">
                                    <div class="card rounded-0">
                                        <img class="card-img rounded-0 img-fluid" src="${image}">
                                        <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                <li><a class="btn btn-success text-white" href="#"><i class="far fa-heart"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2" href="/shop/${product.id}"><i class="far fa-eye"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2" href="#"><i class="fas fa-cart-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="/shop/${product.id}" class="h3 text-decoration-none">${name}</a>
                                        <p class="text-center mb-0">$${price}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#carousel-related-product').html(html);
                    
                    // Initialize slick slider
                    $('#carousel-related-product').slick({
                        infinite: true,
                        arrows: false,
                        slidesToShow: 4,
                        slidesToScroll: 3,
                        dots: true,
                        responsive: [{
                            breakpoint: 1024,
                            settings: { slidesToShow: 3, slidesToScroll: 3 }
                        }, {
                            breakpoint: 600,
                            settings: { slidesToShow: 2, slidesToScroll: 3 }
                        }, {
                            breakpoint: 480,
                            settings: { slidesToShow: 2, slidesToScroll: 3 }
                        }]
                    });
                }
            }
        });
    }

    $(document).on('click', '.add-to-cart-btn', function() {
        const productId = $(this).data('product-id');
        alert('Product added to cart!');
    });
</script>
@endpush

