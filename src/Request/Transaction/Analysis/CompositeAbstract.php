<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Interface CompositeContract
 */
abstract class CompositeAbstract implements CompositeContract
{
    protected $requestType;
    protected $previousRequestId;
    protected $data;

    /**
     * CompositeContract constructor.
     *
     * @param string $requestType
     * @param string $previousRequestId
     * @param array $data
     */
    public function __construct($requestType, $previousRequestId = '', $data = [])
    {
        $this->requestType = $requestType;
        $this->previousRequestId = $previousRequestId;
        $this->data = $data;
    }
}
