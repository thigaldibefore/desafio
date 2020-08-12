<?php


namespace App\Helpers;


class Misc
{

    public static function menuIsActive($menu)
    {
        $explode = explode('/', request()->getPathInfo());
        return $explode[1] == $menu ? 'active' : '';
    }

    public static function getRruleString($rrule)
    {
        switch ($rrule) {
            case null:
                return 'FREQ=DAILY;COUNT=1;';
                break;
            case 'WEEKLY':
                return 'FREQ=WEEKLY;INTERVAL=1;BYDAY=' . substr(strtoupper(date('D')),0,2);
                break;
            case 'MONTHLY':
                return 'FREQ=MONTHLY;INTERVAL=1;COUNT=5;BYMONTHDAY=' . date('d');
                break;
            case 'YEARLY':
                return 'FREQ=YEARLY;INTERVAL=1;BYMONTHDAY=' . date('d') . ';BYMONTH=' . date('m');
                break;
        }
    }

}