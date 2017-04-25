<?php



namespace Payolution\Request;

use Payolution\Request\Transaction\Account;
use Payolution\Request\Transaction\AnalysisFactory;
use Payolution\Request\Transaction\CustomerFactory;
use Payolution\Request\Transaction\Identification;
use Payolution\Request\Transaction\Payment;
use Payolution\Request\Transaction\User;

class TransactionFactory
{
    /**
     * @param string $requestType type of request
     * @param string $paymentBrand payment method
     * @param array $data
     * @param string|bool $referenceId unique id from previous PC or PA request
     *
     * @throws \Exception
     *
     * @return AbstractTransaction|PreCheckTransaction
     */
    public static function create($requestType, $paymentBrand, $data = [], $referenceId = null): AbstractTransaction
    {
        if (!in_array($requestType, RequestTypes::getRequestTypes())) {
            throw new \InvalidArgumentException('Unknown request type "' . $requestType . '""');
        }
        $context = $data['context'];
        $cart = $data['cart'];
        $customerData = $data['customer'];

        $invoiceId = isset($data['invoice']['invoiceId']) ? $data['invoice']['invoiceId'] : '';
        $account = new Account($paymentBrand);

        switch ($requestType) {
            case RequestTypes::PRE_CHECK:
                $billingAddress = $data['billingAddress'];
                $customer = CustomerFactory::create($customerData, $billingAddress);

                $transaction = new PreCheckTransaction(
                    $context['channel'],
                    $context['mode'],
                    new User($context['pwd'], $context['login']),
                    new Payment(
                        RequestTypes::getRequestPaymentCode($requestType),
                        new Payment\Presentation($cart['grandTotal'], self::getUsage($data), $cart['currency'])
                    ),
                    $customer,
                    $account,
                    AnalysisFactory::createRequest(
                        $requestType,
                        $referenceId,
                        $data
                    ),
                    new Identification(
                        $context['transactionId'],
                        $customerData['customerId'],
                        $requestType != RequestTypes::PRE_AUTH ? $referenceId : '',
                        $invoiceId
                    )
                );

                return $transaction;
            case RequestTypes::PRE_AUTH:
                $billingAddress = $data['billingAddress'];
                $customer = CustomerFactory::create($customerData, $billingAddress);

                $transaction = new PreAuthTransaction(
                    $context['channel'],
                    $context['mode'],
                    new User($context['pwd'], $context['login']),
                    new Payment(
                        RequestTypes::getRequestPaymentCode($requestType),
                        new Payment\Presentation($cart['grandTotal'], self::getUsage($data), $cart['currency'])
                    ),
                    $customer,
                    $account,
                    AnalysisFactory::createRequest(
                        $requestType,
                        $referenceId,
                        $data
                    ),
                    new Identification(
                        $context['transactionId'],
                        $customerData['customerId'],
                        '',
                        $invoiceId
                    )
                );

                return $transaction;

            case RequestTypes::CAPTURE:

                $transaction = new CaptureTransaction(
                    $context['channel'],
                    $context['mode'],
                    new User($context['pwd'], $context['login']),
                    new Payment(
                        RequestTypes::getRequestPaymentCode($requestType),
                        new Payment\Presentation($cart['grandTotal'], self::getUsage($data), $cart['currency'])
                    ),
                    AnalysisFactory::createRequest(
                        $requestType,
                        $referenceId,
                        $data
                    ),
                    new Identification($context['transactionId'], $customerData['customerId'], $referenceId, $invoiceId)
                );

                return $transaction;
        }

        throw new \Exception('Request type "' . $requestType . '" not implemented yet.');
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private static function getUsage($data)
    {
        if (isset($data['invoice']['invoiceId'])) {
            return 'Invoice ' . $data['invoice']['invoiceId'];
        }
        if (isset($data['order']['orderId'])) {
            return 'Order ' . $data['order']['orderId'];
        }
        if (isset($data['cart']['cartId'])) {
            return 'Cart ' . $data['cart']['cartId'];
        }

        return '';
    }
}
