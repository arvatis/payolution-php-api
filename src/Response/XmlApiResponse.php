<?php

namespace ArvPayolutionApi\Response;

/**
 * Class XmlApiResponse
 */
class XmlApiResponse extends ResponseAbstract implements ResponseContract
{
    const PROCESSING_STATUS_CODE_SUCCESS = '90';
    const PROCESSING_REASON_CODE_SUCCESS = '00';
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
        if (isset($processingInfo->Status['code']) && $processingInfo->Status['code'] == self::PROCESSING_STATUS_CODE_SUCCESS
            && isset($processingInfo->Reason['code']) && $processingInfo->Reason['code'] == self::PROCESSING_REASON_CODE_SUCCESS
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get full error description from response
     *
     * @return string
     */
    public function getErrorMessage()
    {
        if ($this->getSuccess() || !property_exists($this->xml, 'Transaction')) {
            return '';
        }
        /** @var \SimpleXMLElement $processingInfo */
        $processingInfo = $this->xml->Transaction->Processing;

        return trim(
            $processingInfo->attributes()->code . ' ' . $processingInfo->Result . ' ' . $processingInfo->Status . ' '
            . $processingInfo->Result->attributes()->code . ' ' . $processingInfo->Reason . ' ' . $processingInfo->Return
        );
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        if (!$this->getSuccess() || !property_exists($this->xml, 'Transaction')) {
            return '';
        }
        return (string)$this->xml->Transaction->Identification->ShortID;
    }

    /**
     * @return string
     */
    public function getUniqueID()
    {
        if (!$this->getSuccess() || !property_exists($this->xml, 'Transaction')) {
            return '';
        }
        return (string)$this->xml->Transaction->Identification->UniqueID;
    }

    /**
     * Get the transaction id passed in request
     *
     * @return string
     */
    public function getTransactionID()
    {
        if (!$this->getSuccess() || !property_exists($this->xml, 'Transaction')) {
            return '';
        }
        return (string)$this->xml->Transaction->Identification->TransactionID;
    }
}
