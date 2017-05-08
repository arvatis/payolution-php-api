<?php

namespace ArvPayolutionApi\Response;

/**
 * Class ClientErrorResponse
 */
class ClientErrorResponse extends ResponseAbstract implements ResponseContract
{
    /** @var string */
    private $message;

    /**
     * ClientErrorResponse constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getTransactionID()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getUniqueID()
    {
        return '';
    }
}
