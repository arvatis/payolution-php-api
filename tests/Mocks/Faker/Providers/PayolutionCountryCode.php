<?php



namespace ArvPayolutionApi\Mocks\Faker\Providers;

use Faker\Provider\Base;

/**
 * Class PayolutionCountryCode
 */
class PayolutionCountryCode extends Base
{
    protected static $group = [
        'DE',
        'AT',
        'CH',
        'NL',
    ];

    /**
     * @return mixed
     */
    public function payolutionCountryCode()
    {
        return static::randomElement(static::$group);
    }
}
