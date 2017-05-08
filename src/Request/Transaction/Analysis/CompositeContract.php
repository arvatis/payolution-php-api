<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Interface CompositeContract
 */
interface CompositeContract
{
    /**
     * CompositeContract constructor.
     *
     * @param string $requestType
     * @param string $previousRequestId
     * @param array $data
     */
    public function __construct($requestType, $previousRequestId = '', $data = []);

    /**
     * @return bool
     */
    public function isAvailable();

    /**
     * @return array
     */
    public function collect();
}
