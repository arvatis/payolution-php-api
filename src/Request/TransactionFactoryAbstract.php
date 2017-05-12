<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\AnalysisFactory;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\Payment\Presentation;
use ArvPayolutionApi\Request\Transaction\User;

abstract class TransactionFactoryAbstract
{
    /**
     * @param string $requestType type of request
     * @param string $paymentBrand payment method
     * @param array $data
     * @param string|bool $referenceId unique id from previous PC or PA request
     *
     * @throws \Exception
     *
     * @return TransactionAbstract|PreCheckTransaction
     */
    public static function create($requestType, $paymentBrand, $data = [], $referenceId = null): TransactionAbstract
    {
        $context = $data['context'];
        $cart = isset($data['cart']) ? $data['cart'] : null;
        $cartItems = isset($data['cartItems']) ? $data['cartItems'] : null;
        $customerData = $data['customer'];
        $invoiceId = isset($data['invoice']['invoiceId']) ? $data['invoice']['invoiceId'] : '';
        $shopperId = isset($customerData['customerId']) ? $customerData['customerId'] : null;

        $account = new Account($paymentBrand);

        $analysis = AnalysisFactory::createRequest(
            $requestType,
            $referenceId,
            $data
        );
        $user = new User($context['pwd'], $context['login']);
        $payment = self::createPayment(
            $requestType,
            self::getUsage($data),
            $cart,
            $requestType == RequestTypes::CALCULATION ? self::getTotalTaxAmount($cartItems) : null
        );
        $identification = new Identification(
            $context['transactionId'],
            $shopperId,
            !in_array($requestType, [RequestTypes::PRE_AUTH, RequestTypes::PRE_CHECK]) ? $referenceId : null,
            $invoiceId
        );

        return static::createTransaction(
            $context['channel'],
            $context['mode'],
            $payment,
            $account,
            $analysis,
            $identification,
            $user,
            $data
        );
    }

    /**
     * @param string $channel
     * @param string $mode
     * @param Payment $payment
     * @param Account $account
     * @param Analysis $analysis
     * @param Identification $identification
     * @param User $user
     * @param $data
     *
     * @return TransactionAbstract
     */
    abstract public static function createTransaction(
        $channel,
        $mode,
        Payment $payment,
        Account $account,
        Analysis $analysis,
        Identification $identification,
        User $user,
        $data
    ): TransactionAbstract;

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

    /**
     * @param array $cartItems
     *
     * @return string
     */
    private static function getTotalTaxAmount($cartItems)
    {
        return sprintf('%0.2f', array_sum(array_column($cartItems, 'tax')));
    }

    /**
     * @param $requestType
     * @param $usage
     * @param $cart
     * @param null $taxAmount
     *
     * @return Payment
     */
    private static function createPayment($requestType, $usage, $cart, $taxAmount = null): Payment
    {
        return new Payment(
            new Presentation(
                $cart['grandTotal'],
                $usage,
                $cart['currency'],
                $taxAmount
            ),
            $requestType
        );
    }
}
