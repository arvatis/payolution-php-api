<?php



namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Class SystemInfo
 */
class SystemInfo extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return true;
    }

    /**
     * @return array
     */
    public function collect()
    {
        $systemInfo = $this->data['systemInfo'];
        $data = [
            CriterionNames::PAYOLUTION_TAX_AMOUNT => $this->getTotalTaxAmount(),
            CriterionNames::PAYOLUTION_REQUEST_SYSTEM_VENDOR => $systemInfo['vendor'],
            CriterionNames::PAYOLUTION_REQUEST_SYSTEM_VERSION => $systemInfo['version'],
            CriterionNames::PAYOLUTION_REQUEST_SYSTEM_TYPE => $systemInfo['type'],
            CriterionNames::PAYOLUTION_WEBSHOP_URL => $systemInfo['url'],
            CriterionNames::PAYOLUTION_MODULE_NAME => $systemInfo['module'],
            CriterionNames::PAYOLUTION_MODULE_VERSION => $systemInfo['module_version'],
        ];
        if ($systemInfo['type'] != 'Webshop') {
            unset($data[CriterionNames::PAYOLUTION_WEBSHOP_URL]);
        }

        return $data;
    }

    /**
     * @return string
     */
    private function getTotalTaxAmount(): string
    {
        return sprintf('%0.2f', array_sum(array_column($this->data['cartItems'], 'tax')));
    }
}
