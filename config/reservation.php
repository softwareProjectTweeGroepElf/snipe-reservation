<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:48
 */


return [

    'REVIEWER_ROLE_ID' => [ 2 ], // The Role Ids that can review reservation requests - default: 2

    'LEASING_SERVICE_ROLE_ID' => [ 3 ], // The Role Ids that can check in/out assets - default: 3

    'HOURS_OF_SERVICE' => [             // Hours of service (times open per day) default: every day from 12:00 to 17:00
        'MONDAY' => '12:00-17:00',
        'TUESDAY' => '12:00-17:00',
        'WEDNESDAY' => '12:00-17:00',
        'THURSDAY' => '12:00-17:00',
        'FRIDAY' => '12:00-17:00',
        'SATURDAY' => '12:00-17:00',
        'SUNDAY' => '12:00-17:00'
    ],
];