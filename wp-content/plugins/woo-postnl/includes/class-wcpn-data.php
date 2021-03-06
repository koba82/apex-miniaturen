<?php

use MyParcelNL\Sdk\src\Factory\ConsignmentFactory;
use MyParcelNL\Sdk\src\Model\Consignment\AbstractConsignment;
use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;
use MyParcelNL\Sdk\src\Support\Arr;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (class_exists('WCPN_Data')) {
    return new WCPN_Data();
}

class WCPN_Data
{
    public const API_URL = "https://api.myparcel.nl/";

    /**
     * @var array
     */
    public const CARRIERS_HUMAN = [
        PostNLConsignment::CARRIER_NAME => 'PostNL',
    ];

    /**
     * @var array
     */
    public const DIGITAL_STAMP_RANGES = [
        [
            'min'     => 0,
            'max'     => 20,
            'average' => 15
        ],
        [
            'min'     => 20,
            'max'     => 50,
            'average' => 35
        ],
        [
            'min'     => 50,
            'max'     => 100,
            'average' => 75
        ],
        [
            'min'     => 100,
            'max'     => 350,
            'average' => 225
        ],
        [
            'min'     => 350,
            'max'     => 2000,
            'average' => 1175
        ],
    ];

    public const DEFAULT_COUNTRY_CODE = "NL";
    public const DEFAULT_CARRIER      = PostNLConsignment::CARRIER_NAME;

    /**
     * @var array
     */
    private static $packageTypes;

    /**
     * @var array
     */
    private static $packageTypesHuman;

    /**
     * @var array
     */
    private static $deliveryTypesHuman;

    public function __construct()
    {
        self::$packageTypes = [
            AbstractConsignment::PACKAGE_TYPE_PACKAGE_NAME,
            AbstractConsignment::PACKAGE_TYPE_MAILBOX_NAME,
            AbstractConsignment::PACKAGE_TYPE_LETTER_NAME,
        ];

        self::$packageTypesHuman = [
            AbstractConsignment::PACKAGE_TYPE_PACKAGE_NAME       => __("Package", "woocommerce-postnl"),
            AbstractConsignment::PACKAGE_TYPE_MAILBOX_NAME       => __("Mailbox", "woocommerce-postnl"),
            AbstractConsignment::PACKAGE_TYPE_LETTER_NAME        => __("Unpaid letter", "woocommerce-postnl"),
        ];

        self::$deliveryTypesHuman = [
            AbstractConsignment::DELIVERY_TYPE_MORNING_NAME  => __("Morning delivery", "woocommerce-postnl"),
            AbstractConsignment::DELIVERY_TYPE_STANDARD_NAME => __("Standard delivery", "woocommerce-postnl"),
            AbstractConsignment::DELIVERY_TYPE_EVENING_NAME  => __("Evening delivery", "woocommerce-postnl"),
            AbstractConsignment::DELIVERY_TYPE_PICKUP_NAME   => __("Pickup", "woocommerce-postnl"),
        ];
    }

    /**
     * @return array
     */
    public static function getPackageTypes(): array
    {
        return self::$packageTypes;
    }

    /**
     * @return array
     */
    public static function getPackageTypesHuman(): array
    {
        return self::$packageTypesHuman;
    }

    /**
     * @return array
     */
    public static function getDeliveryTypesHuman(): array
    {
        return self::$deliveryTypesHuman;
    }

    /**
     * @return array
     */
    public static function getDigitalStampRanges(): array
    {
        return self::DIGITAL_STAMP_RANGES;
    }

    /**
     * @param int|string $packageType
     *
     * @return string|null
     */
    public static function getPackageTypeHuman($packageType): ?string
    {
        return self::getHuman(
            $packageType,
            AbstractConsignment::PACKAGE_TYPES_NAMES_IDS_MAP,
            self::$packageTypesHuman
        );
    }

    /**
     * @param string $packageType
     *
     * @return int|null
     */
    public static function getPackageTypeId(string $packageType): ?int
    {
        return Arr::get(AbstractConsignment::PACKAGE_TYPES_NAMES_IDS_MAP, $packageType, null);
    }

    /**
     * @param int $packageType
     *
     * @return string|null
     */
    public static function getPackageTypeName(int $packageType): ?string
    {
        return Arr::get(array_flip(AbstractConsignment::PACKAGE_TYPES_NAMES_IDS_MAP), (string) $packageType, null);
    }

    /**
     * @param string|null $deliveryType
     *
     * @return int|null
     */
    public static function getDeliveryTypeId(?string $deliveryType): ?int
    {
        if (! $deliveryType) {
            $deliveryType = AbstractConsignment::DELIVERY_TYPE_STANDARD;
        }

        return Arr::get(AbstractConsignment::DELIVERY_TYPES_NAMES_IDS_MAP, $deliveryType, null);
    }

    /**
     * @param string|int $key
     * @param array      $map
     * @param array      $humanMap
     *
     * @return string|null
     */
    private static function getHuman($key, array $map, array $humanMap): ?string
    {
        if (is_numeric($key)) {
            $integerMap = array_flip($map);
            $key        = (int) $key;

            if (! array_key_exists($key, $integerMap)) {
                return null;
            }

            $key = $integerMap[$key];
        }

        return $humanMap[$key] ?? null;
    }

    /**
     * @return array
     */
    public static function getInsuranceAmounts(): array
    {
        $amounts = [];

        /**
         * @type PostNLConsignment
         */
        $carrier             = ConsignmentFactory::createByCarrierName(WCPOST_Settings::SETTINGS_POSTNL);
        $amountPossibilities = $carrier::INSURANCE_POSSIBILITIES_LOCAL;

        foreach ($amountPossibilities as $key => $value) {
            $amounts[$value] = $value;
        }

        return $amounts;
    }

    /**
     * @return array
     */
    public static function getCarriersHuman(): array
    {
        return [
            PostNLConsignment::CARRIER_NAME => __("PostNL", "woocommerce-postnl"),
        ];
    }

    /**
     * Check if a given cc matches the default country code.
     *
     * @param string $country
     *
     * @return bool
     */
    public static function isHomeCountry(string $country): bool
    {
        return self::DEFAULT_COUNTRY_CODE === $country;
    }
}

return new WCPN_Data();
