<?php



namespace Payolution\Request;

use Payolution\Request\Transaction\Account;
use Payolution\Request\Transaction\Analysis;
use Payolution\Request\Transaction\Customer;
use Payolution\Request\Transaction\Identification;
use Payolution\Request\Transaction\Payment;
use Payolution\Request\Transaction\User;

/**
 * Class Transaction
 */
abstract class AbstractTransaction
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
     * @return Analysis
     */
    public function getAnalysis(): Analysis
    {
        return $this->analysis;
    }

    /**
     * @return string
     */
    public function _getChannel()
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function _getMode()
    {
        return $this->mode;
    }
}
