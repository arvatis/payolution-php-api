<?php

namespace ArvPayolutionApi\Request;

/**
 * Class Types
 */
class RequestPaymentTypes
{
    const PAYOLUTION_INVOICE = 'PAYOLUTION_INVOICE';
    const PAYOLUTION_ELV = 'PAYOLUTION_ELV';
    const PAYOLUTION_INS = 'PAYOLUTION_INS';

    /**
     * @return mixed
     */
    public static function getPaymentTypes()
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }
}
