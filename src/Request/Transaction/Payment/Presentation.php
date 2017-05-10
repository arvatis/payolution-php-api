<?php

namespace ArvPayolutionApi\Request\Transaction\Payment;

/**
 * Class Presentation
 */
class Presentation
{
    /**
     * @var  string
     */
    protected $amount;
    /**
     * @var  string
     */
    protected $usage;
    /**
     * @var  string
     */
    protected $currency;
    private $vat;

    /**
     * Presentation constructor.
     *
     * @param string $amount
     * @param string $usage
     * @param string $currency
     */
    public function __construct($amount, $usage, $currency, $vat = null)
    {
        $this->amount = $amount;
        $this->usage = $usage;
        $this->currency = $currency;
        $this->vat = $vat;
    }
    /**
     * @return string
     */
    public function getAmount()
    {
        return (string) $this->amount;
    }

    /**
     * @return string
     */
    public function getUsage()
    {
        return (string) $this->usage;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return (string) $this->currency;
    }


    /**
     * Getter for Vat
     * @return mixed
     */
    public function getVAT()
    {
        return $this->vat;
    }
}
