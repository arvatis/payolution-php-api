<?php



namespace Payolution\Request\Transaction\Analysis;

/**
 * Class CompositeAnalysis
 */
class CompositeAnalysis extends CompositeAbstract implements CompositeContract
{
    /**
     * @var CompositeContract[]
     */
    private $parts = [];

    /**
     * CompositeAnalysis constructor.
     *
     * @param string $requestType
     * @param string $previousRequestId
     * @param array $data
     */
    public function __construct($requestType, $previousRequestId = '', $data = [])
    {
        parent::__construct($requestType, $previousRequestId, $data);
    }

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
        $data = [];
        foreach ($this->parts as $part) {
            if ($part->isAvailable()) {
                $data += $part->collect();
            }
        }

        return $data;
    }

    /**
     * @param CompositeContract $item
     *
     * @return $this
     */
    public function add(CompositeContract $item)
    {
        $this->parts[] = $item;

        return $this;
    }
}
