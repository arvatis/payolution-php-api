<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Class Account
 */
class Account extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return isset($this->data['account']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        $account = $this->data['account'];

        return [
            CriterionNames::PAYOLUTION_ACCOUNT_HOLDER => $account['holder'],
            CriterionNames::PAYOLUTION_ACCOUNT_COUNTRY => $account['country'],
            CriterionNames::PAYOLUTION_ACCOUNT_BIC => $account['bic'],
            CriterionNames::PAYOLUTION_ACCOUNT_IBAN => $account['iban'],
        ];
    }
}
