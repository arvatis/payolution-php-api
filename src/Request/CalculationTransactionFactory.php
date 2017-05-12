<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;

class CalculationTransactionFactory extends TransactionFactoryAbstract
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
        return new CalculationTransaction(
            $channel,
            $mode,
            $payment,
            $account,
            $analysis,
            $identification
        );
    }
}
