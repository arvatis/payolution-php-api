<?php


namespace ArvPayolutionApi\Api;

use ArvPayolutionApi\Api\Client as ApiClient;

/**
 * Class ClientFactory
 */
class ApiFactory
{

    /**
     * @param $basicAuthUser
     * @param $basicAuthPassword
     * @param bool $testMode
     * @return RestApi
     */
    public static function createRestApi($basicAuthUser, $basicAuthPassword, $testMode = true)
    {
        $restApi = new RestApi(new ApiClient(), $testMode);
        $restApi->setBasicAuthCredentials($basicAuthUser, $basicAuthPassword);
        return $restApi;
    }

    /**
     * @param bool $testMode
     * @return XmlApi
     */
    public static function createXmlApi($testMode = true)
    {
        return new XmlApi(new ApiClient(), $testMode);
    }
}