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
     * @param AbstractTransaction $transaction
     */
    public function __construct(AbstractTransaction $transaction, $sender)
    {
        $this->transaction = $transaction;
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getSender(): string
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
