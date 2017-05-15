<?php

namespace ArvPayolutionApi\Request;

/**
 * Class CalculationRequestFactory
 */
class CalculationRequestFactory extends RequestFactoryAbstract
{
    /**
     * @return string
     */
    public static function getRequestVersion(): string
    {
        return self::API_VERSION_NUMBER_TWO;
    }

    /**
     * @param $context
     * @param TransactionAbstract $transaction
     *
     * @return mixed
     */
    public static function createRequest($context, TransactionAbstract $transaction)
    {
        return new RestApiRequest($transaction, 'PSP Name');
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
        return CalculationTransactionFactory::create(static::getRequestType(), $paymentBrand, $data, $referenceId);
    }

    public static function getRequestType(): string
    {
        return RequestTypes::CALCULATION;
    }
}
