<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;

class CalculationTransaction extends TransactionAbstract
{
    public function __construct(
        $channel,
        $mode,
        Payment $payment,
        Account $account,
        Analysis $analysis,
        Identification $identification
    ) {
        $this->channel = $channel;
        $this->mode = $mode;
        $this->payment = $payment;
        $this->analysis = $analysis;
        $this->identification = $identification;
    }

    public function getUser()
    {
        return [];
    }
}
