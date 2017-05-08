<?php

namespace ArvPayolutionApi\Mocks\Request;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class XmlMock
 */
class PreCheckXmlMockFactory
{
    private static $allowedPayments = [
        'Invoice',
        'Elv',
        'Installment',
    ];

    /**
     * @param string $paymentMethod
     * @param string $request PreCheck
     *
     * @throws \Exception
     *
     * @return \SimpleXMLElement
     */
    public static function getRequestXml($paymentMethod, $request)
    {
        if (!in_array($paymentMethod, self::$allowedPayments)) {
            throw new \InvalidArgumentException('Unknown payment method "' . $paymentMethod . '"');
        }
        if (!in_array($request, RequestTypes::getRequestTypes())) {
            throw new \InvalidArgumentException('Unknown request type "' . $request . '""');
        }

        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $paymentMethod . DIRECTORY_SEPARATOR . $request . '.xml';

        if (!file_exists($filePath)) {
            throw new \Exception('Xml Mock "' . $filePath . '" not available.');
        }
        $xmlString = file_get_contents($filePath);
        $xmlString = self::setApiConfigValues($xmlString, $paymentMethod, $request);

        return new \SimpleXMLElement($xmlString);
    }

    /**
     * @param $xmlString
     *
     * @return string
     */
    private static function setApiConfigValues($xmlString, $paymentMethod, $requestType)
    {
        $config = Config::getPaymentConfig($paymentMethod, $requestType);

        foreach ($config as $key => $val) {
            $config['{{' . $key . '}}'] = $val;
            unset($config[$key]);
        }

        return strtr($xmlString, $config);
    }
}
