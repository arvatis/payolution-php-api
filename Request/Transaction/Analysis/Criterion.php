<?php



namespace Payolution\Request\Transaction\Analysis;

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
    public function _getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function _getName(): string
    {
        return $this->name;
    }
}
