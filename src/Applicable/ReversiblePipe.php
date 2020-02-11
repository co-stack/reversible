<?php
declare(strict_types=1);
namespace CoStack\Reversible\Applicable;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Reversible;
use function array_reverse;

class ReversiblePipe extends AbstractReversible
{
    /** @var Reversible[] */
    protected $functions = [];

    public function enqueue(Reversible $function): self
    {
        $this->functions[] = $function;
        return $this;
    }

    public function getExecutionClosure(): Closure
    {
        return function($value) {
            foreach ($this->functions as $function) {
                $value = $function->execute($value);
            }
            return $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        return function($value) {
            foreach (array_reverse($this->functions) as $function) {
                $value = $function->reverse($value);
            }
            return $value;
        };
    }
}
