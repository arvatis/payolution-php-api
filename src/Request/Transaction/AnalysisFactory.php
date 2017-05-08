<?php

namespace ArvPayolutionApi\Request\Transaction;

use ArvPayolutionApi\Request\Transaction\Analysis\Account;
use ArvPayolutionApi\Request\Transaction\Analysis\Cart;
use ArvPayolutionApi\Request\Transaction\Analysis\CompositeAnalysis;
use ArvPayolutionApi\Request\Transaction\Analysis\CustomerGroup;
use ArvPayolutionApi\Request\Transaction\Analysis\CustomerNumber;
use ArvPayolutionApi\Request\Transaction\Analysis\CustomerRegistration;
use ArvPayolutionApi\Request\Transaction\Analysis\Installment;
use ArvPayolutionApi\Request\Transaction\Analysis\Invoice;
use ArvPayolutionApi\Request\Transaction\Analysis\Language;
use ArvPayolutionApi\Request\Transaction\Analysis\Order;
use ArvPayolutionApi\Request\Transaction\Analysis\OrderTracking;
use ArvPayolutionApi\Request\Transaction\Analysis\PreCheck;
use ArvPayolutionApi\Request\Transaction\Analysis\PreCheckId;
use ArvPayolutionApi\Request\Transaction\Analysis\Shipping;
use ArvPayolutionApi\Request\Transaction\Analysis\SystemInfo;

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
