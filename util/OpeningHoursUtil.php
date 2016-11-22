<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 22-11-2016
 * Time: 19:52
 */

namespace Reservation\Util;


class OpeningHoursUtil
{
    public function setOpeningHours($monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$until)
    {
        for ($i=0;$i<6;$i++)
        {
            switch ($i)
            {
                case 0:
                    if($monday==null)
                        $monday="Closed";
                    DB::update('update openingHours set openingHours=$monday where day="Monday"');
                    break;

                case 1:
                    if($tuesday==null)
                        $tuesday="Closed";
                    DB::update('update openingHours set openingHours=$tuesday where day="Tuesday"');
                    break;

                case 2:
                    if($wednesday==null)
                        $wednesday="Closed";
                    DB::update('update openingHours set openingHours=$wednesday where day="Wednesday"');
                    break;

                case 3:
                    if($thursday==null)
                        $thursday="Closed";
                    DB::update('update openingHours set openingHours=$thursday where day="Thursday"');
                    break;

                case 4:
                    if($friday==null)
                        $friday="Closed";
                    DB::update('update openingHours set openingHours=$friday where day="Friday"');
                    break;

                case 5:
                    if($saturday==null)
                        $satuday="Closed";
                    DB::update('update openingHours set openingHours=$saturday where day="Saturday"');
                    break;

                case 6:
                    if($sunday==null)
                        $sunday="Closed";
                    DB::update('update openingHours set openingHours=$sunday where day="Sunday"');
                    break;
            }
        }

        $currentDate= date("dd.mm.yyyy");
        DB::update('update openingHours set from=$currentdate');
        if($until==null)
        {
            $until=$currentDate+7776000;
        }
        DB::update('update openingHours set until=$until');






    }

    public function setClosingHours($monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$until)
    {
        for ($i=0;$i<6;$i++)
        {
            switch ($i)
            {
                case 0:
                    if($monday==null)
                        $monday="Closed";
                    DB::update('update closingHours set openingHours=$monday where day="Monday"');
                    break;

                case 1:
                    if($tuesday==null)
                        $tuesday="Closed";
                    DB::update('update closingHours set openingHours=$tuesday where day="Tuesday"');
                    break;

                case 2:
                    if($wednesday==null)
                        $wednesday="Closed";
                    DB::update('update closingHours set openingHours=$wednesday where day="Wednesday"');
                    break;

                case 3:
                    if($thursday==null)
                        $thursday="Closed";
                    DB::update('update closingHours set openingHours=$thursday where day="Thursday"');
                    break;

                case 4:
                    if($friday==null)
                        $friday="Closed";
                    DB::update('update closingHours set openingHours=$friday where day="Friday"');
                    break;

                case 5:
                    if($saturday==null)
                        $satuday="Closed";
                    DB::update('update closingHours set openingHours=$saturday where day="Saturday"');
                    break;

                case 6:
                    if($sunday==null)
                        $sunday="Closed";
                    DB::update('update closingHours set openingHours=$sunday where day="Sunday"');
                    break;
            }
        }


        $currentDate= date("dd.mm.yyyy");
        DB::update('update openingHours set from=$currentdate');

        if($until==null)
        {
            $until=$currentDate+7776000;
        }
        DB::update('update openingHours set until=$until');






    }
}