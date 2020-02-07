<?php
declare(strict_types=1);
namespace CoStack\Reversible;

use Closure;
use function array_reverse;

class ReversibleQueue implements Reversible
{
    /** @var Reversible[] */
    protected $reversibles = [];

    public function enqueue(Reversible $reversible)
    {
        $this->reversibles[] = $reversible;
    }

    public function getExecutionClosure(): Closure
    {
        return static function($value) {
            foreach ($this->reversibles as $reversible) {
                $value = $reversible->getExecutionClosure()($value);
            }
            return $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function($value) {
            foreach (array_reverse($this->reversibles) as $reversible) {
                $value = $reversible->getReversionClosure()($value);
            }
            return $value;
        };
    }
}
