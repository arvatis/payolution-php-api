<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Class Criterion
 */
class Criterion
{
    /**
     * @var  string
     */
    protected $name;
    /**
     * @var  string
     */
    protected $value;

    /**
     * Criterion constructor.
     *
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->name = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function _getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function _getName()
    {
        return $this->name;
    }
}
