<?php

namespace ArvPayolutionApi\Request\Transaction;

/**
 * Class Analysis
 */
class Analysis
{
    /**
     * @var  array
     */
    protected $criterion = [];

    /**
     * @return array
     */
    public function getCriterion(): array
    {
        return $this->criterion;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return Analysis
     */
    public function addCriterion($key, $value)
    {
        $this->criterion[] = [
            '@name' => $key,
            '#' => $value,
        ];

        return $this;
    }
}
