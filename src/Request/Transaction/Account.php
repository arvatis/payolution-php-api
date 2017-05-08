<?php

namespace ArvPayolutionApi\Request\Transaction;

/**
 * Class Account
 */
class Account
{
    /**
     * @var string
     */
    protected $brand;

    /**
     * Account constructor.
     *
     * @param string $brand
     */
    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return str_replace('_B2B', '', $this->brand);
    }
}
