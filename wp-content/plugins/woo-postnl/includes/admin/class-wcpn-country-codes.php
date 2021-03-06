<?php

if (! defined("ABSPATH")) {
    exit;
} // Exit if accessed directly

if (class_exists("WCPN_Country_Codes")) {
    return new WCPN_Country_Codes();
}

class WCPN_Country_Codes
{
    private const EURO_COUNTRIES = [
        'NL',
        'BE',
        'AT',
        'BG',
        'CZ',
        'CY',
        'DK',
        'EE',
        'FI',
        'FR',
        'DE',
        'GR',
        'HU',
        'IE',
        'IT',
        'LV',
        'LT',
        'LU',
        'PL',
        'PT',
        'RO',
        'SK',
        'SI',
        'ES',
        'SE',
        'XK',
    ];

    /**
     * @param string $countryCode
     *
     * @return bool
     */
    public static function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, self::EURO_COUNTRIES);
    }

    /**
     * @param string $countryCode
     *
     * @return bool
     */
    public static function isWorldShipmentCountry(string $countryCode): bool
    {
        return ! self::isEuCountry($countryCode);
    }

    /**
     * @param $countryCode
     *
     * @return bool
     */
    public static function isAllowedDestination(string $countryCode): bool
    {
        $isHomeCountry          = WCPN_Data::isHomeCountry($countryCode);
        $isEuCountry            = self::isEuCountry($countryCode);
        $isWorldShipmentCountry = self::isWorldShipmentCountry($countryCode);

        return $isHomeCountry || $isEuCountry || $isWorldShipmentCountry;
    }
}

return new WCPN_Country_Codes();
