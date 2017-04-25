<?php



namespace Payolution\Request\Transaction;

use Payolution\Request\Transaction\Payment\Presentation;

/**
 * Class Payment
 */
class Payment
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var  Presentation
     */
    protected $presentation;

    /**
     * Payment constructor.
     *
     * @param $code
     * @param Presentation $presentation
     */
    public function __construct($code, Presentation $presentation)
    {
        $this->code = $code;
        $this->presentation = $presentation;
    }

    /**
     * @return mixed
     */
    public function _getCode()
    {
        return $this->code;
    }

    /**
     * @return Presentation
     */
    public function getPresentation(): Presentation
    {
        return $this->presentation;
    }
}
