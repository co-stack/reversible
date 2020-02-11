<?php
declare(strict_types=1);
namespace CoStack\Reversible\Applicable;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Reversible;
use function array_map;
use function is_array;

class ApplyOnArrayValueRecursively extends AbstractReversible
{
    /** @var Reversible */
    private $reversible;

    public function __construct(Reversible $reversible)
    {
        $this->reversible = $reversible;
    }

    public function getExecutionClosure(): Closure
    {
        $reversible = $this->reversible;
        $recursion = null;
        return $recursion = static function($value) use (&$recursion, $reversible) {
            if (is_array($value)) {
                return array_map($recursion, $value);
            }
            return $reversible->getExecutionClosure()($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        $reversible = $this->reversible;
        $recursion = null;
        return $recursion = static function($value) use (&$recursion, $reversible) {
            if (is_array($value)) {
                return array_map($recursion, $value);
            }
            return $reversible->getReversionClosure()($value);
        };
    }

}
