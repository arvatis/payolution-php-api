<?php

namespace ArvPayolutionApi\Request;

/**
 * Class Request
 */
class Request
{
    /**
     * @var  Header
     */
    protected $header;
    /**
     * @var  PreCheckTransaction
     */
    protected $transaction;

    /**
     * Request constructor.
     *
     * @param Header $header
     * @param AbstractTransaction|PreCheckTransaction $transaction
     */
    public function __construct(Header $header, AbstractTransaction $transaction)
    {
        $this->header = $header;
        $this->transaction = $transaction;
    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
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
