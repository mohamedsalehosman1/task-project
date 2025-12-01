 <?php


if (! Breadcrumbs::exists('dashboard.home')) {
  Breadcrumbs::for('dashboard.home', function ($breadcrumb) {
    $breadcrumb->push('Dashboard', route('dashboard.home'));
    });

}

Breadcrumbs::for('dashboard.admins.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('accounts::admins.plural'), route('dashboard.admins.index'));
});

Breadcrumbs::for('dashboard.admins.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.admins.index');
    $breadcrumb->push(trans('accounts::admins.actions.create'), route('dashboard.admins.create'));
});

Breadcrumbs::for('dashboard.admins.show', function ($breadcrumb, $admin) {
    $breadcrumb->parent('dashboard.admins.index');
    $breadcrumb->push($admin->name, route('dashboard.admins.show', $admin));
});

Breadcrumbs::for('dashboard.admins.edit', function ($breadcrumb, $admin) {
    $breadcrumb->parent('dashboard.admins.show', $admin);
    $breadcrumb->push(trans('accounts::admins.actions.edit'), route('dashboard.admins.edit', $admin));
});

if (!Breadcrumbs::exists('dashboard.users.index')) {
    Breadcrumbs::for('dashboard.users.index', function ($breadcrumb) {
        $breadcrumb->parent('dashboard.home');
        $breadcrumb->push(trans('accounts::user.plural'), route('dashboard.users.index'));
    });
}

if (!Breadcrumbs::exists('dashboard.users.create')) {
    Breadcrumbs::for('dashboard.users.create', function ($breadcrumb) {
        $breadcrumb->parent('dashboard.users.index');
        $breadcrumb->push(trans('accounts::user.actions.create'), route('dashboard.users.create'));
    });
}

if (!Breadcrumbs::exists('dashboard.users.show')) {
    Breadcrumbs::for('dashboard.users.show', function ($breadcrumb, $user) {
        $breadcrumb->parent('dashboard.users.index');
        $breadcrumb->push($user->name, route('dashboard.users.show', $user));
    });
}

if (!Breadcrumbs::exists('dashboard.users.edit')) {
    Breadcrumbs::for('dashboard.users.edit', function ($breadcrumb, $user) {
        $breadcrumb->parent('dashboard.users.show', $user);
        $breadcrumb->push(trans('accounts::user.actions.edit'), route('dashboard.users.edit', $user));
    });
}

if (!Breadcrumbs::exists('dashboard.users.trashed')) {
    Breadcrumbs::for('dashboard.users.trashed', function ($breadcrumb) {
        $breadcrumb->parent('dashboard.users.index');
        $breadcrumb->push(trans('accounts::user.trashedPlural'), route('dashboard.users.trashed'));
    });
}

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
