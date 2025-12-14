@extends('frontend::templatemo.layout')

@section('title', 'Zay Shop - Product Listing Page')

@section('content')
    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 pb-4">Categories</h1>
                <ul class="list-unstyled templatemo-accordion" id="categories-sidebar">
                    <!-- Categories will be loaded here -->
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="{{ route('frontend.shop') }}">All</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control" id="sort-select">
                                <option value="featured">Featured</option>
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="name_asc">Name: A to Z</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="products-container">
                    <!-- Products will be loaded dynamically -->
                </div>
                <div class="row">
                    <ul class="pagination pagination-lg justify-content-end" id="pagination">
                        <!-- Pagination will be loaded here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    let currentSort = 'featured';
    
    $(document).ready(function() {
        loadProducts();
        
        $('#sort-select').on('change', function() {
            currentSort = $(this).val();
            currentPage = 1;
            loadProducts();
        });
    });

    function loadProducts(page = 1) {
        currentPage = page;
        $.ajax({
            url: API_BASE_URL + '/products',
            method: 'GET',
            data: { 
                page: page,
                per_page: 9,
                sort: currentSort
            },
            success: function(response) {
                if (response.success && response.data) {
                    const products = response.data.data || response.data;
                    let html = '';
                    
                    products.forEach(function(product) {
                        const image = product.media && product.media.length > 0 
                            ? product.media[0].original_url 
                            : '{{ asset("templatemo_559_zay_shop/assets/img/shop_01.jpg") }}';
                        const price = product.price || '0.00';
                        const name = product.name || 'Product';
                        
                        html += `
                            <div class="col-md-4">
                                <div class="card mb-4 product-wap rounded-0">
                                    <div class="card rounded-0">
                                        <img class="card-img rounded-0 img-fluid" src="${image}" alt="${name}">
                                        <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                <li><a class="btn btn-success text-white" href="#"><i class="far fa-heart"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2" href="/shop/${product.id}"><i class="far fa-eye"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2 add-to-cart" data-product-id="${product.id}"><i class="fas fa-cart-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="/shop/${product.id}" class="h3 text-decoration-none">${name}</a>
                                        <ul class="list-unstyled d-flex justify-content-center mb-1">
                                            <li>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-warning fa fa-star"></i>
                                                <i class="text-muted fa fa-star"></i>
                                                <i class="text-muted fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <p class="text-center mb-0">$${price}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#products-container').html(html);
                    
                    // Load pagination if available
                    if (response.data.current_page) {
                        loadPagination(response.data);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error loading products:', xhr);
            }
        });
    }

    function loadPagination(data) {
        let html = '';
        if (data.current_page > 1) {
            html += `<li class="page-item"><a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#" onclick="loadProducts(${data.current_page - 1}); return false;">Previous</a></li>`;
        }
        
        for (let i = 1; i <= data.last_page; i++) {
            html += `<li class="page-item ${i === data.current_page ? 'disabled' : ''}">
                <a class="page-link ${i === data.current_page ? 'active' : ''} rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#" onclick="loadProducts(${i}); return false;">${i}</a>
            </li>`;
        }
        
        if (data.current_page < data.last_page) {
            html += `<li class="page-item"><a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#" onclick="loadProducts(${data.current_page + 1}); return false;">Next</a></li>`;
        }
        
        $('#pagination').html(html);
    }

    $(document).on('click', '.add-to-cart', function() {
        const productId = $(this).data('product-id');
        // Add to cart functionality
        alert('Product added to cart!');
    });
</script>
@endpush

