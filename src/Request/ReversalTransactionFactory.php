<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;

class ReversalTransactionFactory extends TransactionFactoryAbstract
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
        return new ReversalTransaction(
            $channel,
            $mode,
            $user,
            $payment,
            $analysis,
            $identification,
            $account
        );
    }
}
