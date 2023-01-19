<?php

namespace App\Helpers;

use DateTime;

class TimeUrlDecoder
{
    public static function decode(string $datetime): string
    {
        return (new DateTime(urldecode($datetime)))->format('Y-m-d H:i:s');
    }
}