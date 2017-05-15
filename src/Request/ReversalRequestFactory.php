<?php

namespace ArvPayolutionApi\Request;

class ReversalRequestFactory extends RequestFactoryAbstract
{
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
        return ReversalTransactionFactory::create(static::getRequestType(), $paymentBrand, $data, $referenceId);
    }

    public static function getRequestType(): string
    {
        return RequestTypes::REVERSAL;
    }
}
