<?php



namespace ArvPayolutionApi\Request;

/**
 * Class Header
 */
class Header
{
    /**
     * @var  string
     */
    protected $sender;

    /**
     * Security constructor.
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
    public function getSecurity()
    {
        return ['@sender' => $this->sender];
    }
}
