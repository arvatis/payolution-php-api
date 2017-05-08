<?php

namespace ArvPayolutionApi\Mocks\Faker\Providers;

use Faker\Provider\Base;

/**
 * Class CustomerGroup
 */
class CustomerGroup extends Base
{
    protected static $group = [
        'B2B / Händler netto',
        'Shopkunden',
        'Top',
    ];

    /**
     * @return mixed
     */
    public function customerGroup()
    {
        return static::randomElement(static::$group);
    }
}
