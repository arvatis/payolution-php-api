<?php



namespace Payolution\Request\Transaction\Payment;

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

    /**
     * Presentation constructor.
     *
     * @param string $amount
     * @param string $usage
     * @param string $currency
     */
    public function __construct($amount, $usage, $currency)
    {
        $this->amount = $amount;
        $this->usage = $usage;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return (string) $this->amount;
    }

    /**
     * @return string
     */
    public function getUsage(): string
    {
        return (string) $this->usage;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return (string) $this->currency;
    }
}
