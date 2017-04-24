<?php



namespace Tests\Payolution\Helpers;

use Payolution\Api\Request\RequestTypes;

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
            throw new \Exception('Please create a config file "phpunit.ini". See "phpunit.ini.dist" for reference.');
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
        $conf = self::getConfig();
        $requestConf = [
            'sender' => $conf['api_context']['sender'],
            'channel' => self::getChannel($paymentMethod, $requestType, $conf),
            'pwd' => $conf['api_context']['pwd'],
            'login' => $conf['api_context']['login'],
        ];

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
        $channel = $conf['api_context_' . strtolower($paymentMethod)]['channel'];
        if ($requestType == RequestTypes::PRE_CHECK) {
            $channel = $conf['api_context_' . strtolower($paymentMethod)]['channel_precheck'];

            return $channel;
        }

        return $channel;
    }
}
