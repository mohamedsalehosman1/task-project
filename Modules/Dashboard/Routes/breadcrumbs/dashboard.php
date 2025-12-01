<?php

use Elnooronline\Breadcrumbs\Facades\Breadcrumbs;

// داشبورد
Breadcrumbs::for('dashboard.home', function ($breadcrumb) {
    $breadcrumb->push('Dashboard', route('dashboard.home'));
});

