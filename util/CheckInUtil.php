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


    public static function calculateFine($assetId)
    {
        $result=DB::table('reservation_assets')->select('until')->first();
        $currentDate= date("m.d.y");

        strtotime($currentDate);
        strtotime($result);


        $verschil=$currentDate-$result;

        $verschil=$verschil/86400;

        $verschil = floor($verschil);
        return $boeteBedrag=$verschil*50;
    }


    public static function checkCurrentDate($assetId)
    {
        $result=DB::select('select expected_checkin from assets where id=$assetId');
        $currentDate= date("dd.mm.yyyy");

        strtotime($currentDate);
        strtotime($result);

        if ($result<$currentDate)
        {
            CheckInUtil::CheckIn($assetId);
        }
        else
        {
            $fine=calculateFine($assetId);


            //$view= view::make('teLaat')->with('fine',$fine);
            //return view('teLaat',['fine'=>$fine]);
            return View::make('teLaat')->with('fine',$fine);
           // return Redirect::route('teLaat')->with('fine',$fine);

        }
    }



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