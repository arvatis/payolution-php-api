<?php

namespace ArvPayolutionApi\Helpers;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class Config
 */
class Config
{
    /**
     * Return config from phpunit.ini file
     *
     * @throws \Exception
     *
     * @return array
     */
    public static function getConfig()
    {
        $configFile = 'phpunit.ini';
        if (!file_exists($configFile) || !is_readable($configFile)) {
            throw new \Exception('Please create a config file "phpunit.ini" in "' . getcwd() . '". See "phpunit.ini.dist" for reference.');
        }

        $config = parse_ini_file($configFile, true);

        return $config;
    }

    /**
     * @param $paymentMethod
     * @param $requestType
     *
     * @return array
     */
    public static function getPaymentConfig($paymentMethod, $requestType)
    {
        $paymentMethod = strtolower($paymentMethod);
        $conf = self::getConfig();
        $requestConf = self::getDefaultApiContext($conf) +
            self::getPaymentApiContext($paymentMethod, $conf) +
            [
                'channel' => self::getChannel($paymentMethod, $requestType, $conf),
            ];
        unset($requestConf['channel_precheck']);
        return $requestConf;
    }

    /**
     * @param $paymentMethod
     * @param $requestType
     * @param $conf
     *
     * @return mixed
     */
    private static function getChannel($paymentMethod, $requestType, $conf)
    {
        $channel = self::getPaymentApiContext($paymentMethod, $conf)['channel'];
        if ($requestType == RequestTypes::PRE_CHECK) {
            $channel = self::getPaymentApiContext($paymentMethod, $conf)['channel_precheck'];

            return $channel;
        }

        return $channel;
    }

    /**
     * @param $conf
     * @return mixed
     */
    private static function getDefaultApiContext($conf)
    {
        return $conf['api_context'];
    }

    /**
     * @param $paymentMethod
     * @param $conf
     * @return mixed
     */
    private static function getPaymentApiContext($paymentMethod, $conf)
    {
        return $conf['api_context_' . $paymentMethod];
    }
}
