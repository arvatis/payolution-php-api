<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;

class CalculationRequestFactory
{
    public static function create(
        $channel,
        $mode,
        Payment $payment,
        Account $account,
        Analysis $analysis,
        Identification $identification
    ) {
        return new CalculationTransaction($channel,
            $mode,
            $payment,
            $account,
            $analysis,
            $identification
        );
    }
}
