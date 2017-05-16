<?php

namespace ArvPayolutionApi\Helpers;

/**
 * Class Transaction
 */
class TransactionHelper
{
    /**
     * @param $method
     *
     * @return string
     */
    public static function getUniqueTransactionId($method): string
    {
        return substr(strrchr($method, '\\'), 1) . '_' . time();
    }
}
