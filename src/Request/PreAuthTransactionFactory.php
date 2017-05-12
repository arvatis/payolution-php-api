<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\CustomerFactory;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;

class PreAuthTransactionFactory extends TransactionFactoryAbstract
{
    public static function createTransaction(
        $channel,
        $mode,
        Payment $payment,
        Account $account,
        Analysis $analysis,
        Identification $identification,
        User $user,
        $data
    ): TransactionAbstract {
        $customer = CustomerFactory::create($data['customer'], $data['billingAddress']);

        return new PreAuthTransaction(
            $channel,
            $mode,
            $user,
            $payment,
            $customer,
            $account,
            $analysis,
            $identification
        );
    }
}
