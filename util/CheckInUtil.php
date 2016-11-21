<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:07
 */

namespace Reservation\Util;


class CheckInUtil
{
        public static function CheckIn($assetId)
        {
            $AssetStatus=DB::select('select checked_in from assets where id=$assetId');
            if($assetId==true)
            {
                DB::update('update assets set checked_in=FALSE where id=$assetId');
            }
            else
            {
                return "Asset already checked in.";
            }


        }
}