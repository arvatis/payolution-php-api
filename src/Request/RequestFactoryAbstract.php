<?php

namespace ArvPayolutionApi\Request;

abstract class RequestFactoryAbstract
{
    const API_VERSION_NUMBER_ONE = '1.0';
    const API_VERSION_NUMBER_TWO = '2.0';

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
                    '@version' => static::getRequestVersion(),
                    '#' => static::createRequestObject($requestType, $paymentBrand, $data, $referenceId),
                ],
                true,
                ($requestType == RequestTypes::CALCULATION)
            )
        );
    }

    /**
     * @param $context
     * @param TransactionAbstract $transaction
     *
     * @return XmlApiRequest|RestApiRequest
     */
    abstract public static function createRequest($context, TransactionAbstract $transaction);

    /**
     * @return string
     */
    abstract public static function getRequestVersion(): string;

    abstract public static function createTransaction($requestType, $paymentBrand, $data, $referenceId);

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
        $transaction = static::createTransaction($requestType, $paymentBrand, $data, $referenceId);

        return static::createRequest($data['context'], $transaction);
    }
}
