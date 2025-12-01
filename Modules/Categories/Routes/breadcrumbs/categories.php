<?php

Breadcrumbs::for('dashboard.categories.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('categories::categories.plural'), route('dashboard.categories.index'));
});

Breadcrumbs::for('dashboard.categories.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push(trans('categories::categories.actions.create'), route('dashboard.categories.create'));
});

Breadcrumbs::for('dashboard.categories.order', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push(trans('categories::categories.actions.order'), route('dashboard.order.form.categories'));
});

Breadcrumbs::for('dashboard.categories.show', function ($breadcrumb, $client) {
    $breadcrumb->parent('dashboard.categories.index');
    $breadcrumb->push($client->name, route('dashboard.categories.show', $client));
});

Breadcrumbs::for('dashboard.categories.edit', function ($breadcrumb, $client) {
    $breadcrumb->parent('dashboard.categories.show', $client);
    $breadcrumb->push(trans('categories::categories.actions.edit'), route('dashboard.categories.edit', $client));
});
