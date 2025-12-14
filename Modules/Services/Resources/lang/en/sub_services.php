<?php

return [
    'plural' => 'Sub Services',
    'trashedPlural' => 'Deleted Sub Services',
    'singular' => 'Sub Service',
    'in' => 'In',
    'parent' => 'Parent Sub Service',
    'empty' => 'There are no Sub Services',
    'select' => 'Select Sub Service',
    'perPage' => 'Count Results Per Page',
    'filter' => 'Search for Sub Service',
    'actions' => [
        'list' => 'List Sub Services',
        'show' => 'Show Sub Service',
        'create' => 'Create Sub Service',
        'new' => 'New',
        'edit' => 'Edit Sub Service',
        'delete' => 'Delete Sub Service',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'invalid_create' => 'You cannot add it under this Sub Service.',
        'created' => 'The Sub Service has been created successfully.',
        'updated' => 'The Sub Service has been updated successfully.',
        'deleted' => 'The Sub Service has been deleted successfully.',
    ],
    'attributes' => [
        'name' => 'Name',
        'parent_id' => 'Parent Sub Service',
        'image' => 'Sub Service Image',
        'additional_image' => 'Additional Image',
        'status' => 'Status',
        'where_to_serve' => 'Where To Serve Service',

    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the Sub Service ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
    ],

    "where_to_serve" => [
        "in" => "inside the store",
        "out" => "outside the store",
        "inOut" => "inside and outside the store",
    ]
];
