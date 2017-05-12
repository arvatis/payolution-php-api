<?php

namespace ArvPayolutionApi\Request;

class RefundRequestFactory extends RequestFactoryAbstract
{
    /**
     * @param $requestType
     * @param $paymentBrand
     * @param $data
     * @param $referenceId
     *
     * @return TransactionAbstract|PreCheckTransaction
     */
    public static function createTransaction($requestType, $paymentBrand, $data, $referenceId)
    {
        return RefundTransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);
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
}
