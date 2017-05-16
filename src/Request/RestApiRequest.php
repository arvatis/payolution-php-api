<?php

namespace ArvPayolutionApi\Request;

/**
 * Class Request
 */
class RestApiRequest
{
    /**
     * @var  PreCheckTransaction
     */
    protected $transaction;
    private $sender;

    /**
     * XmlApiRequest constructor.
     *
     * @param TransactionAbstract $transaction
     */
    public function __construct(TransactionAbstract $transaction, $sender)
    {
        $this->transaction = $transaction;
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return array
     */
    public function getTransaction()
    {
        return [
            '@channel' => $this->transaction->_getChannel(),
            '@mode' => $this->transaction->_getMode(),
            '#' => $this->transaction,
        ];
    }
}
