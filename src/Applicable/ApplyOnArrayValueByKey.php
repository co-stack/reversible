<?php
declare(strict_types=1);
namespace CoStack\Reversible\Applicable;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Reversible;

class ApplyOnArrayValueByKey extends AbstractReversible
{
    private $reversible;
    private $keys;

    public function __construct(Reversible $reversible, array $keys)
    {
        $this->reversible = $reversible;
        $this->keys = $keys;
    }

    public function getExecutionClosure(): Closure
    {
        return function(array $value): array {
            foreach ($this->keys as $key) {
                if (!empty($value[$key])) {
                    $value[$key] = $this->reversible->execute($value[$key]);
                }
            }
            return $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(array $value): array {
            foreach ($this->keys as $key) {
                if (!empty($value[$key])) {
                    $value[$key] = $this->reversible->reverse($value[$key]);
                }
            }
            return $value;
        };
    }

}
