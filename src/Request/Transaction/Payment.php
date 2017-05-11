<?php

namespace ArvPayolutionApi\Request\Transaction;

use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\Transaction\Payment\Presentation;

/**
 * Class Payment
 */
class Payment
{
    const REST_API_OPERATION_TYPE = 'CALCULATION';
    const REST_API_PAYMENT_TYPE = 'INSTALLMENT';
    /**
     * @var string
     */
    protected $code;

    /**
     * @var  Presentation
     */
    protected $presentation;
    private $restApiPaymentType;
    private $restApiOperationType;

    /**
     * Payment constructor.
     *
     * @param Presentation $presentation
     * @param $requestType
     */
    public function __construct(Presentation $presentation, $requestType)
    {
        $this->code = RequestTypes::getRequestPaymentCode($requestType);
        $this->presentation = $presentation;
        if ($requestType == RequestTypes::CALCULATION) {
            $this->restApiPaymentType = self::REST_API_PAYMENT_TYPE;
            $this->restApiOperationType = self::REST_API_OPERATION_TYPE;
        }
    }

    /**
     * @return string|null
     */
    public function _getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->restApiOperationType;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->restApiPaymentType;
    }

    /**
     * @return Presentation
     */
    public function getPresentation(): Presentation
    {
        return $this->presentation;
    }
}
