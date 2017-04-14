<?php namespace EC\Config;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class HConfig
{

    static private $Properties = null;

    static public function Get($package_name, $property_name, $default_value = null)
    {
        self::Initialize();

        if (!isset(self::$Properties[$package_name]))
            return $default_value;
        if (!isset(self::$Properties[$package_name][$property_name]))
            return $default_value;

        return self::$Properties[$package_name][$property_name];
    }

    static public function GetRequired($package_name, $property_name)
    {
        self::Initialize();

        if (!isset(self::$Properties[$package_name]))
            throw new \Exception("Config property `{$package_name}.{$property_name}`" .
                    " not set.");
        if (!isset(self::$Properties[$package_name][$property_name]))
            throw new \Exception("Config property `{$package_name}.{$property_name}`" .
                    " not set.");

        return self::$Properties[$package_name][$property_name];
    }

    static public function Initialize()
    {
        if (self::$Properties !== null)
            return;

        self::$Properties = [];
        self::RequireConfigFile(self::$Properties);
    }

    static private function RequireConfigFile()
	{
		if (!file_exists(PATH_DATA . '/config/Config.php'))
			throw new \Exception('Config file `'.$file_path.'` does not exist.');

		$eConfig = new CConfig_Setter();

		unset($file_path);

		require(PATH_DATA . '/Config/config.php');

        self::$Properties = array_merge_recursive(self::$Properties,
                $eConfig->getProperties());
	}

}
