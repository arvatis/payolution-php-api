<?php

namespace ArvPayolutionApi\Request;

class CaptureRequestFactory extends RequestFactoryAbstract
{
    public static function getRequestType(): string
    {
        return RequestTypes::CAPTURE;
    }

    /**
     * @return string
     */
    public static function getRequestVersion(): string
    {
        return self::API_VERSION_NUMBER_ONE;
    }

    /**
     * @param $context
     * @param TransactionAbstract $transaction
     *
     * @return mixed
     */
    public static function createRequest($context, TransactionAbstract $transaction)
    {
        $header = new Header($context['sender']);

        return new XmlApiRequest($header, $transaction);
    }

    /**
     * @param $paymentBrand
     * @param $data
     * @param $referenceId
     *
     * @return PreCheckTransaction|TransactionAbstract
     *
     * @internal param $requestType
     */
    public static function createTransaction($paymentBrand, $data, $referenceId)
    {
        return CaptureTransactionFactory::create(static::getRequestType(), $paymentBrand, $data, $referenceId);
    }
}
