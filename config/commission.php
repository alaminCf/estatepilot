<?php

/*
 * London Abason Ltd. Commission Chart.
 *
 * Each customer payment feeds a "pool" (percentage of the payment amount)
 * that is distributed across the seller's upline chain:
 *   - every upline gets their own stored override % (defaults below),
 *   - the seller receives the remainder: pool − sum(upline overrides).
 *
 * Example (booking pool 50): AGM sells → AGM 44%, G.M 3%, E.D 3%.
 */
return [

    // Pool totals as % of the payment amount, keyed by pool type.
    'pools' => [
        'booking' => 50,
        'down' => 20,
        'instalment' => 15,
    ],

    // Maps payments.payment_type to a pool type.
    'payment_type_pools' => [
        'Booking Payment' => 'booking',
        'Down Payment' => 'down',
        'Installment Payment' => 'instalment',
        'Part Of Installment' => 'instalment',
    ],

    /*
     * Commission user types ordered top → bottom.
     * 'parent' is the type the immediate upline must have (null = top level).
     * 'defaults' pre-fill the per-user override percentages (booking/down/instalment)
     * on the add form; admin may change them per user.
     */
    'types' => [
        'ed' => [
            'label' => 'E.D',
            'parent' => null,
            'defaults' => ['booking' => 3, 'down' => 2, 'instalment' => 2],
        ],
        'gm' => [
            'label' => 'G.M',
            'parent' => 'ed',
            'defaults' => ['booking' => 3, 'down' => 2, 'instalment' => 2],
        ],
        'agm' => [
            'label' => 'AGM',
            'parent' => 'gm',
            'defaults' => ['booking' => 4, 'down' => 3, 'instalment' => 2],
        ],
        'manager' => [
            'label' => 'Manager',
            'parent' => 'agm',
            'defaults' => ['booking' => 5, 'down' => 4, 'instalment' => 3],
        ],
        'ast_manager' => [
            'label' => 'Ast. Manager',
            'parent' => 'manager',
            'defaults' => ['booking' => 35, 'down' => 9, 'instalment' => 6],
        ],
    ],
];
