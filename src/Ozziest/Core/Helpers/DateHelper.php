<?php namespace Ozziest\Core\Helpers;

use DateTime, DateInterval;

class DateHelper {
    
    public static function getExpiredDate($period = 'PT30M')
    {
        $now = new DateTime();
        $now = $now->add(new DateInterval($period));
        return $now->format('Y-m-d H:i:s');
    }
    
}