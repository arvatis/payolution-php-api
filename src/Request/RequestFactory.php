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
     * @return Request
     */
    public static function create($requestType, $paymentBrand, $data = [], $referenceId = null): Request
    {
        $context = $data['context'];

        $transaction = TransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);

        return new Request(new Header($context['sender']), $transaction);
    }
}
