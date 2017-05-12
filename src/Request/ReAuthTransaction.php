<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Analysis\Account;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;
use ArvPayolutionApi\Request\Transaction\Account;

class ReAuthTransaction extends TransactionAbstract
{
    /**
     * ReAuthTransaction constructor.
     *
     * @param string $channel
     * @param string $mode
     * @param User $user
     * @param Payment $payment
     * @param Account $account
     * @param Analysis $analysis
     * @param Identification $identification
     */
    public function __construct($channel, $mode, $user, $payment, $account, $analysis, $identification)
    {
    }
}
