<?php

namespace ArvPayolutionApi\Response;

/**
 * Class XmlApiResponse
 */
class XmlApiResponse extends ResponseAbstract implements ResponseContract
{
    const PROCESSING_STATUS_CODE_SUCCESS = 90;
    const PROCESSING_REASON_CODE_SUCCESS = 0;
    /**
     * @var  \SimpleXMLElement
     */
    protected $xml;

    /**
     * XmlApiResponse constructor.
     *
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml(): \SimpleXMLElement
    {
        return $this->xml;
    }

    /**
     * Request success
     *
     * @return bool
     */
    public function getSuccess()
    {
        if (!property_exists($this->xml, 'Transaction')) {
            return false;
        }
        $processingInfo = $this->xml->Transaction->Processing;
        if ($processingInfo->Status->attributes() . '' != self::PROCESSING_STATUS_CODE_SUCCESS
            || $processingInfo->Reason->attributes() . '' != self::PROCESSING_REASON_CODE_SUCCESS
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get full error description from response
     *
     * @return string
     */
    public function getErrorMessage()
    {
        if ($this->getSuccess()) {
            return '';
        }
        /** @var \SimpleXMLElement $processingInfo */
        $processingInfo = $this->xml->Transaction->Processing;

        return trim(
            $processingInfo->attributes() . ' ' . $processingInfo->Result . ' ' . $processingInfo->Status . ' '
            . $processingInfo->Result->attributes() . ' ' . $processingInfo->Reason
        );
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        return (string) $this->xml->Transaction->Identification->ShortID;
    }

    /**
     * @return string
     */
    public function getUniqueID()
    {
        return (string) $this->xml->Transaction->Identification->UniqueID;
    }

    /**
     * Get the transaction id passed in request
     *
     * @return string
     */
    public function getTransactionID()
    {
        return (string) $this->xml->Transaction->Identification->TransactionID;
    }
}
