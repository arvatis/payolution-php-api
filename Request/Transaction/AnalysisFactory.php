<?php



namespace Payolution\Request\Transaction;

use Payolution\Request\Transaction\Analysis\Account;
use Payolution\Request\Transaction\Analysis\Cart;
use Payolution\Request\Transaction\Analysis\CompositeAnalysis;
use Payolution\Request\Transaction\Analysis\CustomerGroup;
use Payolution\Request\Transaction\Analysis\CustomerNumber;
use Payolution\Request\Transaction\Analysis\CustomerRegistration;
use Payolution\Request\Transaction\Analysis\Installment;
use Payolution\Request\Transaction\Analysis\Invoice;
use Payolution\Request\Transaction\Analysis\Language;
use Payolution\Request\Transaction\Analysis\Order;
use Payolution\Request\Transaction\Analysis\OrderTracking;
use Payolution\Request\Transaction\Analysis\PreCheck;
use Payolution\Request\Transaction\Analysis\PreCheckId;
use Payolution\Request\Transaction\Analysis\Shipping;
use Payolution\Request\Transaction\Analysis\SystemInfo;

/**
 * Class AnalysisFactory
 */
class AnalysisFactory
{
    /**
     * @param $requestType
     * @param string|bool $referenceId
     * @param array $data
     *
     * @return Analysis
     */
    public static function createRequest($requestType, $referenceId, $data = []): Analysis
    {
        $customer = $data['customer'];
        $language = $customer['language'];

        $composite = new CompositeAnalysis($requestType, $referenceId, $data);
        $composite
            ->add(new Account($requestType, $referenceId, $data))
            ->add(new Installment($requestType, $referenceId, $data))
            ->add(new PreCheck($requestType, $referenceId, $data))
            ->add(new PreCheckId($requestType, $referenceId, $data))
            ->add(new Language($requestType, $referenceId, $language))
            ->add(new CustomerRegistration($requestType, $referenceId, $data))
            ->add(new SystemInfo($requestType, $referenceId, $data))
            ->add(new Cart($requestType, $referenceId, $data))
            ->add(new CustomerNumber($requestType, $referenceId, $data))
            ->add(new CustomerGroup($requestType, $referenceId, $data))
            ->add(new Shipping($requestType, $referenceId, $data))
            ->add(new OrderTracking($requestType, $referenceId, $data))
            ->add(new Order($requestType, $referenceId, $data))
            ->add(new Invoice($requestType, $referenceId, $data))
        ;

        $criterionData = $composite->collect();
        $analysis = new Analysis();
        foreach ($criterionData as $key => $value) {
            $analysis->addCriterion($key, $value);
        }

        return $analysis;
    }
}
