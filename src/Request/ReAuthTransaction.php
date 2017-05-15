<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;

/**
 * Class ReAuthTransaction
 */
class ReAuthTransaction extends PreCheckTransaction
{
    /**
     * Transaction constructor.
     *
     * @param string $channel
     * @param string $mode
     * @param User $user
     * @param Payment $payment
     * @param Account $account
     * @param Analysis $analysis
     * @param Identification $identification
     */
    public function __construct(
        $channel,
        $mode,
        User $user,
        Payment $payment,
        Account $account,
        Analysis $analysis,
        Identification $identification
    ) {
        $this->channel = $channel;
        $this->mode = $mode;
        $this->user = $user;
        $this->payment = $payment;
        $this->account = $account;
        $this->analysis = $analysis;
        $this->identification = $identification;
    }
}
