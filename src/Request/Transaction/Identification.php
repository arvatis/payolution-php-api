<?php



namespace ArvPayolutionApi\Request\Transaction;

/**
 * Class Identification
 */
class Identification
{
    /**
     * @var  string
     */
    protected $transactionId;
    /**
     * @var  string
     */
    protected $shopperId;

    /**
     * @var string
     */
    private $invoiceId;
    /**
     * @var string
     */
    private $referenceId;

    /**
     * Identification constructor.
     *
     * @param string $transactionId
     * @param string $shopperId
     * @param string $referenceId
     * @param string $invoiceId
     */
    public function __construct($transactionId, $shopperId, $referenceId = '', $invoiceId = '')
    {
        $this->transactionId = $transactionId;
        $this->shopperId = $shopperId;
        $this->invoiceId = $invoiceId;
        $this->referenceId = $referenceId;
    }

    /**
     * @return string
     */
    public function getTransactionID(): string
    {
        return (string) $this->transactionId;
    }

    /**
     * Getter for ReferenceId
     *
     * @return string
     */
    public function getReferenceID(): string
    {
        return (string) $this->referenceId;
    }

    /**
     * Getter for InvoiceId
     *
     * @return string
     */
    public function getInvoiceID(): string
    {
        return (string) $this->invoiceId;
    }

    /**
     * @return string
     */
    public function getShopperID(): string
    {
        return (string) $this->shopperId;
    }
}
