<?php

namespace ArvPayolutionApi\Request;

class CaptureRequestFactory extends RequestFactoryAbstract
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
     * @param $requestType
     * @param $paymentBrand
     * @param $data
     * @param $referenceId
     *
     * @return TransactionAbstract|PreCheckTransaction
     */
    public static function createTransaction($requestType, $paymentBrand, $data, $referenceId)
    {
        return CaptureTransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);
    }
}
