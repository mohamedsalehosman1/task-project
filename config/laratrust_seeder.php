<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'super_admin' => [
            'products' => 'c,r,u,d,s,so',
            'categories' => 'c,r,u,d,s,so',

            'roles' => 'c,r,u,d,s',
            'admins' => 'c,r,u,d,s,b',
            'users' => 'c,r,u,d,s,b,rt,re,f',
            'washers' => 'c,r,u,d,s,b,rt,re,f',
            'packages' => 'c,r,u,d,s',
            'washer_packages' => 'c,r,u,d,s',
            'services' => 'c,r,u,d,s',
            'items' => 'c,r,u,d,s',
            'tags' => 'c,r,u,d,s',
            'f_a_qs' => 'c,r,u,d,s',
            'contactus' => 'r,d,s',
            'notifications' => 'c,r,u,d,s',
            'settings' => 'c,r,u,d,s',
           // 'attributes' => 'c,r,u,d,s',
            'orders' => 'c,r,u,d,s',
            'sub_services' => 'c,r,u,d,s',

        ],
        'vendor' => [
            'orders' => 'r,u,d,s',
            'notifications' => 'r,d,s',
            'items' => 'c,r,u,d,s',
        ],
        'washer' => [
            'washers' => 'u,s',
            'items' => 'c,r,u,d,s',
            'washer_packages' => 'c,r,u,d,s',
            'notifications' => 'r,d,s',
            'orders' => 'c,r,u,d,s',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'show',
        'b' => 'block',
        'dl' => 'download',
        'so' => 'sort',
        'rt' => 'readTrashed',
        're' => 'restore',
        'f' => 'forceDelete',
        'a' => 'attach',
        'st' => 'status',
    ]
];
