<?php

return [
    'singular' => 'Product',
    'plural' => 'Products',
    'empty' => 'There are no Products yet.',
    'count' => 'Products count',
    'search' => 'Search',
    'select' => 'Select Product',
    'perPage' => 'Products Per Page',
    'filter' => 'Search for Product',
    'actions' => [
        'list' => 'List all',
        'create' => 'Create Product',
        'show' => 'Show Product',
        'edit' => 'Edit Product',
        'delete' => 'Delete Product',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The Product has been created successfully.',
        'updated' => 'The Product has been updated successfully.',
        'deleted' => 'The Product has been deleted successfully.',
        'cant-delete' => "The Product Can't Be Deleted becasue it's Related to Other Data ",
        'images_note' => 'Supported types: jpeg, png,jpg | Max File Product:10MB',
    ],
    'attributes' => [
        'name' => 'Product Name',
        'image' => 'Product Image',
        'description' => 'Product Description',
        'quantity' => 'Quantity',
        'price' => 'Price',
        'price_with_offer' => 'Price (Offer Price :price) ',
        'old_price' => 'Old Price',
        'is_recommended' => 'Is Recommended',
        'total' => 'Total',
        'cover' => 'Cover',
        'images' => 'Images',
        'material' => 'Material',
        'made_in' => 'Made In',
        'vendor' => 'vendor',
        'recommended' => 'Is Recomended'
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the Product ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
    ],
];
