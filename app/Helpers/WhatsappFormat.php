<?php

namespace App\Helpers;

class WhatsappFormat
{
    public static function format($phone)
    {
        return 'https://wa.me/62'.substr($phone, 1);
    }

    public static function formatHtml($phone)
    {
        $formattedPhone = self::format($phone);

        return '<a href="'.$formattedPhone.'" target="_blank">'.$phone.'</a>';
    }
}
