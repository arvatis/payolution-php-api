<?php

namespace ArvPayolutionApi\Request;

/**
 * Class RequestTypes
 */
class RequestTypes
{
    const PRE_CHECK = 'PreCheck';
    const PRE_AUTH = 'PreAuth';
    const RE_AUTH = 'ReAuth';
    const CAPTURE = 'Capture';
    const REVERSAL = 'Reversal';
    const REFUND = 'Refund';
    const CALCULATION = 'Calculation';

    /**
     * @return mixed
     */
    public static function getRequestTypes()
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }

    /**
     * @param $requestType
     *
     * @return string
     */
    public static function getRequestPaymentCode($requestType)
    {
        switch ($requestType) {
            case self::PRE_AUTH:
            case self::PRE_CHECK:
            case self::RE_AUTH:
            return 'VA.PA';
            case self::CAPTURE:
                return 'VA.CP';
            case self::REVERSAL:
                return 'VA.RV';
            case self::REFUND:
                return 'VA.RF';
        }
        if (!in_array($requestType, self::getRequestTypes())) {
            throw new \InvalidArgumentException('Unknown request type "' . $requestType . '""');
        }
        return '';
    }
}
