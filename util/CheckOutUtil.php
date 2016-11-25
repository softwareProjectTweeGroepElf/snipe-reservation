<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:24
 */

namespace Reservation\Util;


class CheckOutUtil
{
    public static function checkOut($assetId,$userId)
    {

        $currentDate= date("dd.mm.yyyy");
        strtotime($currentDate);

        $expectedCheckin=$currentDate+604800;
        //This is the amount of seconds in one week.



        $assetStatus=DB::select('select checked_in from assets where id=$assetId');
        $requestable=DB::select('select requestable from assets WHERE id=$assetId');
        $archived=DB::select('select archived from assets WHERE id=$assetId');


        if($assetId==true && $requestable==true && $archived==false)
        {
            return "Asset already checked out.";
        }
        else
        {
            DB::update('update assets set checked_in=TRUE WHERE id=$assetId');
            DB::update('update assets set expected_checkin=$expectedCheckin WHERE id=$assetId');
            DB::update('update assets set assigned_to=$userId WHERE  id=$assetId');
            DB::update('update assets set last_checkout=$currentDate WHERE  id=$assetId');
        }


    }

}