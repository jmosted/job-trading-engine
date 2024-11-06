<?php

namespace App\Utils;
use Carbon\Carbon;

class DateUtil {
    const DATE_FORMAT_ES = 'd/m/Y';
	const DATE_FROMAT_EN = 'm/d/Y';
	const DATE_FORMAT_ES_hhmm = 'd/m/Y H:i';
	const DATE_FORMAT_YYYY_MM_DD = 'Y-m-d';
	const DATE_FORMAT_YYYY_MM_DDThhmm = 'Y-m-d H:i';
	const DATE_FORMAT_YYYY_MM_DDThhmmss = 'Y-m-d H:i:s';

    public static function stringToDate($stringDate) : Carbon {
        $today = Carbon::now();
        return Carbon::createFromFormat(self::DATE_FORMAT_ES,$stringDate)
            ->hours($today->hour)
            ->minutes($today->minute);
    }
}