<?php

namespace ArvPayolutionApi\Request;

class PreAuthRequestFactory extends RequestFactoryAbstract
{
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
        return PreAuthTransactionFactory::create(static::getRequestType(), $paymentBrand, $data, $referenceId);
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

    public static function getRequestType(): string
    {
        return RequestTypes::PRE_AUTH;
    }
}
