<?php



namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\Transaction\Account;
use ArvPayolutionApi\Request\Transaction\Analysis;
use ArvPayolutionApi\Request\Transaction\Customer;
use ArvPayolutionApi\Request\Transaction\Identification;
use ArvPayolutionApi\Request\Transaction\Payment;
use ArvPayolutionApi\Request\Transaction\User;

/**
 * Class Transaction
 */
class PreCheckTransaction extends AbstractTransaction
{
    /**
     * @var  string
     */
    protected $channel;
    /**
     * @var  string
     */
    protected $mode;
    /**
     * @var  User
     */
    protected $user;
    /**
     * @var  Payment
     */
    protected $payment;
    /**
     * @var  Customer
     */
    protected $customer;
    /**
     * @var  Account
     */
    protected $account;
    /**
     * @var  Analysis
     */
    protected $analysis;
    /**
     * @var Identification
     */
    protected $identification;

    /**
     * Transaction constructor.
     *
     * @param string $channel
     * @param string $mode
     * @param User $user
     * @param Payment $payment
     * @param Customer $customer
     * @param Account $account
     * @param Analysis $analysis
     * @param Identification $identification
     */
    public function __construct(
        $channel,
        $mode,
        User $user,
        Payment $payment,
        Customer $customer = null,
        Account $account,
        Analysis $analysis,
        Identification $identification
    ) {
        $this->channel = $channel;
        $this->mode = $mode;
        $this->user = $user;
        $this->payment = $payment;
        $this->customer = $customer;
        $this->account = $account;
        $this->analysis = $analysis;
        $this->identification = $identification;
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return [
            '@pwd' => $this->user->_getPwd(),
            '@login' => $this->user->_getLogin(),
            '#' => $this->user,
        ];
    }

    /**
     * Getter for Identification
     *
     * @return Identification
     */
    public function getIdentification(): Identification
    {
        return $this->identification;
    }

    /**
     * @return array
     */
    public function getPayment()
    {
        return [
            '@code' => $this->payment->_getCode(),
            '#' => $this->payment,
        ];
    }

    /**
     * @return  Customer|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }
}
