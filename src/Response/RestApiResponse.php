<?php

namespace ArvPayolutionApi\Response;

/**
 * Class XmlApiResponse
 */
class RestApiResponse extends ResponseAbstract implements ResponseContract
{
    const STATUS_SUCCESS = 'OK';
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
        if (!property_exists($this->xml, 'Status')) {
            return false;
        }

        return $this->xml->Status == self::STATUS_SUCCESS;
    }

    /**
     * Get full error description from response
     *
     * @return string
     */
    public function getErrorMessage()
    {
        if ($this->getSuccess() || !property_exists($this->xml, 'Status')) {
            return '';
        }

        return $this->xml->StatusCode . ' ' . $this->xml->Status . ' ' . $this->xml->Reason;
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getUniqueID()
    {
        return (string) $this->xml->Identification->UniqueID;
    }

    /**
     * Get the transaction id passed in request
     *
     * @return string
     */
    public function getTransactionID()
    {
        return (string) $this->xml->Identification->TransactionID;
    }

    public function getTermsAndConditionsUrl()
    {
        return (string) $this->xml->AdditionalInformation->TacUrl;
    }

    public function getDataPrivacyConsentUrl()
    {
        return (string) $this->xml->AdditionalInformation->DataPrivacyConsentUrl;
    }

    /**
     * @return array
     */
    public function getPaymentPlans()
    {
        $installmentData = [];
        foreach ($this->xml->PaymentDetails as $plan) {
            $installments = [];
            foreach ($plan->Installment as $installment) {
                $installments[] = [
                    'amount' => (string) $installment->Amount,
                    'dueDate' => (string) $installment->Due,
                ];
            }
            $installmentData[(string) $plan->Duration] = [
                'originalAmount' => (string) $plan->OriginalAmount,
                'totalAmount' => (string) $plan->TotalAmount,
                'minimumInstallmentFee' => (string) $plan->MinimumInstallmentFee,
                'duration' => (string) $plan->Duration,
                'interestRate' => (string) $plan->InterestRate,
                'effectiveInterestRate' => (string) $plan->EffectiveInterestRate,
                'usage' => (string) $plan->Usage,
                'currency' => (string) $plan->Currency,
                'standardCreditInformationUrl' => (string) $plan->StandardCreditInformationUrl,
                'installments' => $installments,
            ];
        }

        return $installmentData;
    }
}
