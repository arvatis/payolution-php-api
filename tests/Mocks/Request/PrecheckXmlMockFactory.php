<?php

namespace ArvPayolutionApi\Mocks\Request;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class XmlMock
 */
class PreCheckXmlMockFactory
{
    private static $allowedPayments = [
        RequestPaymentTypes::PAYOLUTION_INVOICE => 'Invoice',
        RequestPaymentTypes::PAYOLUTION_ELV => 'Elv',
        RequestPaymentTypes::PAYOLUTION_INS => 'Installment',
        RequestPaymentTypes::PAYOLUTION_INVOICE_B2B => 'InvoiceB2B',
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
        if (!isset(self::$allowedPayments[$paymentMethod])) {
            throw new \InvalidArgumentException('Unknown payment method "' . $paymentMethod . '"');
        }
        if (!in_array($request, RequestTypes::getRequestTypes())) {
            throw new \InvalidArgumentException('Unknown request type "' . $request . '""');
        }

        $filePath = __DIR__ . DIRECTORY_SEPARATOR . self::$allowedPayments[$paymentMethod] . DIRECTORY_SEPARATOR . $request . '.xml';

        if (!file_exists($filePath)) {
            throw new \Exception('Xml Mock "' . $filePath . '" not available.');
        }
        $xmlString = file_get_contents($filePath);
        $xmlString = self::setApiConfigValues($xmlString, self::$allowedPayments[$paymentMethod], $request);

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
