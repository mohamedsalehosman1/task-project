<?php

return [
    'pending' => [
        'user' => [
            'subject' => 'Thank you for your order.',
            'body' => 'Your Order is Pending, Please wait until the order is reviewed by the vendor'
        ],
        'worker' => [
            'subject' => 'you have a new order.',
            'body' => 'you have a new order #:id available'
        ],
    ],



    'accepted' => [
        'user' => [
            'subject' => 'Your Order #:id is Accepted.',
            'body' => 'Your Order #:id is Accepted, Please wait until the order is assigned to a delivery driver.'
        ],
        'delivery' => [
            'subject' => 'you have a new order.',
            'body' => 'you have a new order #:id available'
        ],
    ],


    'onwayToClient' => [
        'user' => [
            'subject' => 'Your Order #:id is Assigned to delivery driver.',
            'body' => 'Your Order #:id is Assigned to delivery driver, Please wait until the delivery driver arrives at your location.'
        ],
        'worker' => [
            'subject' => 'Order #:id is accepted by delivery driver.',
            'body' => 'Order #:id is on way to client'
        ],
    ],


    'pickedFromClient' => [

        'user' => [
            'subject' => 'Order #:id is picked up by delivery driver.',
            'body' => 'Order #:id is picked up by delivery driver, its on way to laundry store.'
        ],

        'worker' => [
            'subject' => 'Order #:id is picked up by delivery driver.',
            'body' => 'Order #:id is on way to client, Please wait until the delivery driver arrives at your location.'
        ],

    ],

    'deliveredToLaundry' => [

        'user' => [
            'subject' => 'Order #:id is delivered to laundry by delivery driver.',
            'body' => 'Order #:id delivered to laundry by delivery driver, its short listed for washing.'
        ],

        'worker' => [
            'subject' => 'Order #:id is delivered to laundry by delivery driver.',
            'body' => 'Order #:id is delivered to laundry by delivery driver, Please wait until the delivery driver arrives at your location.'
        ],
    ],

    'inProgress' => [

        'user' => [
            'subject' => 'Order #:id is being washed.',
            'body' => 'Order #:id is being washed by laundry store.'
        ]

    ],

    'finishWashing' => [

        'user' => [
            'subject' => 'Order #:id is being washed.',
            'body' => 'Order #:id is being washed by laundry store.'
        ],

        'delivery' => [
            'subject' => 'you have a new order.',
            'body' => 'you have a new order #:id available.'
        ],
    ],

    'onwayToLaundry' => [

        'user' => [
            'subject' => 'Your Order #:id is Assigned to delivery driver.',
            'body' => 'Your Order #:id is Assigned to delivery driver'
        ],

        'worker' => [
            'subject' => 'Order #:id is accepted by delivery driver.',
            'body' => 'Order #:id is on way to client, Please wait until the delivery driver arrives at your location.'
        ],
    ],

    'pickedFromLaundry' => [

        'user' => [
            'subject' => 'Order #:id is picked up by delivery driver.',
            'body' => 'Order #:id is picked up by delivery driver, Please wait until the delivery driver arrives at your location.'
        ],

        'worker' => [
            'subject' => 'Order #:id is picked up by delivery driver.',
            'body' => 'Order #:id is on way to client'
        ],
    ],


    'deliveredToClient' => [
        'user' => [
            'subject' => 'Order #:id is delivered to client by delivery driver.',
            'body' => 'Order #:id delivered to client by delivery driver, its short listed for delivery.'
        ],

        'worker' => [
            'subject' => 'Order #:id is delivered to client by delivery driver.',
            'body' => 'Order #:id is delivered to client by delivery driver, Please wait until the delivery driver arrives at your location.'
        ],

    ],


    'deliveredByClient' => [

        'user' => [
            'subject' => 'You have Reserved Order #:id.',
            'body' => 'You have Reserved Order #:id.'
        ],

        'worker' => [
            'subject' => 'Order #:id is Reserved by client.',
            'body' => 'Order #:id is Reserved by client.'
        ],
    ],

    'refund' => [
        'user' => [

            'true' => [
                'subject' => 'Your refund request has been sent for order #:id',
                'body' => 'Your payment has been refunded successfully'
            ],

            'false' => [
                'subject' => 'Your refund request has been sent for order #:id',
                'body' => 'please contact the technical support'
            ]

        ]
    ],


    'cancelled' => [
        'subject' => 'Your Order has been Canceled',
        'body' => 'The store has canceled order #:id',
        'body_reason' => 'The store has canceled order #:id due to :reason',
        'system_body' => 'Your order #:id has been canceled because it exceeded the allowed time for order acceptance or assignment to a delivery driver by the store.',
        'reasons' => [
            'vendor has been deleted from application' => 'Vendor has been deleted from application',
            'vendor has been blocked from application' => 'Vendor has been blocked from application',
            'service has been deleted from this vendor' => 'Service has been deleted from this vendor',
        ]
    ],



    'user-types' => [
        'user' => 'User',
        'delivery' => 'Delivery',
        'worker' => 'Worker',
        'admin' => 'admin',
        'other' => 'Other'
    ]

];
