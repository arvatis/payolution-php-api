<?php



namespace Payolution\Api\Request;

use Payolution\Request\Transaction\Analysis;
use Payolution\Request\Transaction\Identification;
use Payolution\Request\Transaction\Payment;
use Payolution\Request\Transaction\User;

/**
 * Class CaptureTransaction
 */
class CaptureTransaction extends AbstractTransaction
{
    /**
     * Transaction constructor.
     *
     * @param string $channel
     * @param string $mode
     * @param User $user
     * @param Payment $payment
     * @param Analysis $analysis
     * @param Identification $identification
     */
    public function __construct(
        $channel,
        $mode,
        User $user,
        Payment $payment,
        Analysis $analysis,
        Identification $identification
    ) {
        $this->channel = $channel;
        $this->mode = $mode;
        $this->user = $user;
        $this->payment = $payment;
        $this->analysis = $analysis;
        $this->identification = $identification;
    }
}
