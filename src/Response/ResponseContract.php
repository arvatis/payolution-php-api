<?php

namespace ArvPayolutionApi\Response;

/**
 * Class XmlApiResponse
 */
interface ResponseContract
{
    /**
     * Request success
     *
     * @return bool
     */
    public function getSuccess();

    /**
     * Get full error description from response
     *
     * @return string
     */
    public function getErrorMessage();

    /**
     * @return string
     */
    public function getShortId();

    /**
     * @return string
     */
    public function getUniqueID();

    /**
     * Get the transaction id passed in request
     *
     * @return string
     */
    public function getTransactionID();

    /**
     * @return array
     */
    public function toArray();
}
