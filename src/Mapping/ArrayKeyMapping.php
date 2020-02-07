<?php
declare(strict_types=1);
namespace CoStack\Reversible\Mapping;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function array_flip;
use function ksort;

class ArrayKeyMapping extends AbstractReversible
{
    private $mapping;

    /**
     * ArrayKeyMapping constructor.
     * @param array $mapping Key = Numeric, Value = assoc index
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function getExecutionClosure(): Closure
    {
        return function(array $value): array {
            $mapping = array_flip($this->mapping);
            $newValue = [];
            foreach ($value as $key => $var) {
                $newValue[$mapping[$key]] = $var;
            }
            ksort($newValue);
            return $newValue;
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(array $value): array {
            $newValue = [];
            foreach ($this->mapping as $numIndex => $assocIndex) {
                $newValue[$assocIndex] = $value[$numIndex];
            }
            return $newValue;
        };
    }

}
