<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:48
 */


return [

    'REVIEWER_ROLES' => [ 'admin' ], // The Role Ids that can review reservation requests - default: 'admin'

    'LEASING_SERVICE_ROLES' => [ 'admin' ], // The Roles that can check in/out assets - default: 'admin'

    'HOURS_OF_SERVICE' => [             // Hours of service (times open per day) default: every day from 12:00 to 17:00
        'MONDAY' => '12:00-17:00',
        'TUESDAY' => '12:00-17:00',
        'WEDNESDAY' => '12:00-17:00',
        'THURSDAY' => '12:00-17:00',
        'FRIDAY' => '12:00-17:00',
        'SATURDAY' => '12:00-17:00',
        'SUNDAY' => '12:00-17:00'
    ],

    'MANAGER_EMAIL' => 'changeme@snipeit.com', // The head of the lending service's email, used for daily overviews

    'MAX_LOAN_DURATION' => 30, // The maximum amount of days an asset can be lended

    /**
     *  Description of all the options
     */
    'REVIEWER_ROLES_DESCRIPTION' => 'De groepen die authorisatie hebben om uitleenaanvragen te bekijken en beheren.',

    'LEASING_SERVICE_ROLES_DESCRIPTION' => 'De groepen die kwalificeren als uitleendienst.',

    'HOURS_OF_SERVICE_DESCRIPTION' => 'Het aantal uren in een week dat de uitleendienst open is.',

    'MANAGER_EMAIL_DESCRIPTION' => 'De e-mail van de hoofd van de uitleendienst.',

    'MAX_LOAN_DURATION_DESCRIPTION' => 'Het maximum aantal dagen dat iets mag worden uitgeleend.'
];