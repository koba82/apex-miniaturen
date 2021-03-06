<?php

use migration\WCPN_Upgrade_Migration;

if (! defined('ABSPATH')) {
    exit;
}

if (class_exists('WCPN_Upgrade_Migration_v4_1_0')) {
    return new WCPN_Upgrade_Migration_v4_1_0();
}

/**
 * Migrates pre v4.1.0 settings
 */
class WCPN_Upgrade_Migration_v4_1_0 extends WCPN_Upgrade_Migration
{
    /**
     * @var array
     */
    private $newGeneralSettings = [];

    /**
     * @var array
     */
    private $newExportDefaultsSettings = [];

    /**
     * @var array
     */
    private $newCheckoutSettings = [];

    /**
     * @var array
     */
    private $newPostNlSettings = [];

    /**
     * @var array
     */
    private $oldGeneralSettings;

    /**
     * @var array
     */
    private $oldCheckoutSettings;

    /**
     * @var array
     */
    private $oldExportDefaultsSettings;

    public function __construct()
    {
        parent::__construct();
    }

    protected function import(): void
    {
        require_once(WCPOST()->plugin_path() . '/vendor/autoload.php');
        require_once(WCPOST()->plugin_path() . '/includes/admin/settings/class-wcpost-settings.php');
        require_once(WCPOST()->plugin_path() . '/includes/class-wcpn-data.php');
    }

    protected function migrate(): void
    {
        $this->oldGeneralSettings        = $this->getSettings("woocommerce_postnl_general_settings");
        $this->oldCheckoutSettings       = $this->getSettings("woocommerce_postnl_checkout_settings");
        $this->oldExportDefaultsSettings = $this->getSettings("woocommerce_postnl_export_defaults_settings");
        $oldPostNlSettings               = $this->getSettings("woocommerce_postnl_postnl_settings");

        $this->newGeneralSettings        = $this->oldGeneralSettings;
        $this->newCheckoutSettings       = $this->oldCheckoutSettings;
        $this->newExportDefaultsSettings = $this->oldExportDefaultsSettings;
        $this->newPostNlSettings         = $oldPostNlSettings;

        $this->migrateGeneralSettings();
        $this->migrateCheckoutSettings();
        $this->migrateExportDefaultsSettings();

        $this->correctPostNlInsurance();
    }

    protected function setOptionSettingsMap(): void
    {
        $this->optionSettingsMap = [
            "woocommerce_postnl_general_settings"         => $this->newGeneralSettings,
            "woocommerce_postnl_checkout_settings"        => $this->newCheckoutSettings,
            "woocommerce_postnl_export_defaults_settings" => $this->newExportDefaultsSettings,
            "woocommerce_postnl_postnl_settings"          => $this->newPostNlSettings,
        ];
    }

    private function migrateGeneralSettings(): void
    {
        $this->newGeneralSettings = $this->migrateSettings(
            self::getGeneralMap(),
            $this->newGeneralSettings,
            $this->oldGeneralSettings
        );
    }

    private function migrateCheckoutSettings(): void
    {
        // Migrate existing checkout settings to new keys
        $this->newCheckoutSettings = $this->migrateSettings(
            self::getCheckoutMap(),
            $this->newCheckoutSettings,
            $this->oldCheckoutSettings
        );

        // Migrate old checkout settings to PostNL
        $this->newPostNlSettings = $this->migrateSettings(
            self::getCheckoutPostnlMap(),
            $this->newPostNlSettings,
            $this->oldCheckoutSettings
        );
    }

    private function migrateExportDefaultsSettings(): void
    {
        $this->newPostNlSettings = $this->migrateSettings(
            self::getExportDefaultsPostnlMap(),
            $this->newPostNlSettings,
            $this->oldExportDefaultsSettings
        );

        $this->newExportDefaultsSettings = $this->removeOldSettings(
            self::getExportDefaultsPostnlMap(),
            $this->newExportDefaultsSettings
        );
    }

    /**
     * @return array
     */
    private static function getGeneralMap(): array
    {
        return [
            'print_position_offset' => WCPOST_Settings::SETTING_ASK_FOR_PRINT_POSITION,
        ];
    }

    /**
     * @return array
     */
    private static function getCheckoutPostnlMap(): array
    {
        $postnl = WCPOST_Settings::SETTINGS_POSTNL;

        return [
            "delivery_options_enabled" => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_ENABLED,
            "evening_enabled"          => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_EVENING_ENABLED,
            "evening_fee"              => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_EVENING_FEE,
            "morning_enabled"          => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_MORNING_ENABLED,
            "morning_fee"              => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_MORNING_FEE,
            "postnl_checkout"        => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DELIVERY_ENABLED,
            "only_recipient_enabled"   => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_ONLY_RECIPIENT_ENABLED,
            "only_recipient_fee"       => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_ONLY_RECIPIENT_FEE,
            "saturday_cutoff_enabled" =>  "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_MONDAY_DELIVERY_ENABLED,
        ];
    }

    /**
     * @return array
     */
    private static function getCheckoutMap(): array
    {
        return [
            "at_home_delivery" => WCPOST_Settings::SETTING_DELIVERY_TITLE,
        ];
    }

    /**
     * @return array
     */
    private static function getExportDefaultsPostnlMap(): array
    {
        $postnl = WCPOST_Settings::SETTINGS_POSTNL;

        return [
            "insured_amount" => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DEFAULT_EXPORT_INSURED_AMOUNT,
//            "large_format"   => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DEFAULT_EXPORT_LARGE_FORMAT,
            "only_recipient" => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DEFAULT_EXPORT_ONLY_RECIPIENT,
            "return"         => "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DEFAULT_EXPORT_RETURN,
        ];
    }

    /**
     * In case the current amount is not valid, choose the closest value from the allowed values (rounded up).
     */
    private function correctPostNlInsurance(): void
    {
        $postnl           = WCPOST_Settings::SETTINGS_POSTNL;
        $key              = "{$postnl}_" . WCPOST_Settings::SETTING_CARRIER_DEFAULT_EXPORT_INSURED_AMOUNT;
        $availableAmounts = WCPN_Data::getInsuranceAmounts();
        $insuranceAmount  = $this->newPostNlSettings[$key];

        if (! in_array($insuranceAmount, $availableAmounts)) {
            $closestValue = $this->roundUpToMatch($insuranceAmount, $availableAmounts);

            $this->newPostNlSettings[$key] = $closestValue;
        }
    }

    /**
     * @param int   $target
     * @param int[] $possibleValues
     *
     * @return int
     */
    private function roundUpToMatch(int $target, array $possibleValues): int
    {
        rsort($possibleValues);
        $match = 0;

        foreach ($possibleValues as $i => $value) {
            if ($value < $target) {
                break;
            }

            $match = $i;
        }

        return $possibleValues[$match];
    }
}

return new WCPN_Upgrade_Migration_v4_1_0();
