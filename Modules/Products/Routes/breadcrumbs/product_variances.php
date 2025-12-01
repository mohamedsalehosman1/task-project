<?php

Breadcrumbs::for('dashboard.product_variances.index', function ($breadcrumb , $product) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('products::product_variances.plural'), route('dashboard.product_variances.index' , $product));
});

Breadcrumbs::for('dashboard.product_variances.create', function ($breadcrumb, $product) {
    $breadcrumb->parent('dashboard.product_variances.index' , $product);
    $breadcrumb->push(trans('products::product_variances.actions.create'), route('dashboard.product_variances.create' , $product));
});

Breadcrumbs::for('dashboard.product_variances.show', function ($breadcrumb, $product) {
    $breadcrumb->parent('dashboard.product_variances.index' , $product);
    $breadcrumb->push($product->name, route('dashboard.product_variances.show', $product));
});

Breadcrumbs::for('dashboard.product_variances.edit', function ($breadcrumb, $product) {
    $breadcrumb->parent('dashboard.product_variances.show', $product);
    $breadcrumb->push(trans('products::product_variances.actions.edit'), route('dashboard.product_variances.edit', $product));
});
