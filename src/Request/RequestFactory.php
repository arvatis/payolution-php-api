<?php

namespace ArvPayolutionApi\Request;

/**
 * Class RequestFactory
 */
class RequestFactory
{
    /**
     * @param string $requestType type of request
     * @param string $paymentBrand payment method
     * @param array $data
     * @param string|bool $referenceId unique id from previous PC or PA request
     *
     * @return \SimpleXMLElement
     */
    public static function create($requestType, $paymentBrand, $data = [], $referenceId = null)
    {
        $xmlSerializer = XmlSerializerFactory::create();

        return new \SimpleXMLElement(
            $xmlSerializer->serialize(
                [
                    '@version' => self::getRequestVersion($requestType),
                    '#' => self::createRequestObject($requestType, $paymentBrand, $data, $referenceId),
                ],
                true,
                ($requestType == RequestTypes::CALCULATION)
            )
        );
    }

    /**
     * @param $requestType
     * @param $paymentBrand
     * @param $data
     * @param $referenceId
     *
     * @return RestApiRequest|XmlApiRequest
     */
    private static function createRequestObject($requestType, $paymentBrand, $data, $referenceId)
    {
        $context = $data['context'];

        $transaction = TransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);

        if ($requestType != RequestTypes::CALCULATION) {
            $header = new Header($context['sender']);

            return new XmlApiRequest($header, $transaction);
        }

        return new RestApiRequest($transaction, 'PSP Name');
    }

    /**
     * @param $requestType
     *
     * @return string
     */
    private static function getRequestVersion($requestType): string
    {
        return $requestType != RequestTypes::CALCULATION ? '1.0' : '2.0';
    }
}
