<?php

namespace ArvPayolutionApi\Request;

class ReAuthRequestFactory extends RequestFactoryAbstract
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
        return ReAuthTransactionFactory::create(static::getRequestType(), $paymentBrand, $data, $referenceId);
    }

    /**
     * @return string
     */
    public static function getRequestVersion()
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

    public static function getRequestType()
    {
        return RequestTypes::RE_AUTH;
    }
}
