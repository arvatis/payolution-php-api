<?php

namespace ArvPayolutionApi\Request;

/**
 * Class Sender
 */
class Sender
{
    /**
     * @var  string
     */
    protected $sender;

    /**
     * Sender constructor.
     *
     * @param $sender
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return array
     */
    public function getSender()
    {
        return $this->sender;
    }
}
