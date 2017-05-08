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
