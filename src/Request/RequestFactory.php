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
     * @return XmlApiRequest
     */
    public static function create($requestType, $paymentBrand, $data = [], $referenceId = null)
    {
        $context = $data['context'];

        $transaction = TransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);

        if ($requestType != RequestTypes::CALCULATION) {
            $header = new Header($context['sender']);
            return new XmlApiRequest($header, $transaction);
        }
        return new RestApiRequest($transaction, 'PSP Name');
    }
}
