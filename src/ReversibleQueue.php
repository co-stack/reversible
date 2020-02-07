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
        $reversibles = $this->reversibles;
        return static function($value) use ($reversibles) {
            foreach ($reversibles as $reversible) {
                $value = $reversible->getExecutionClosure()($value);
            }
            return $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        $reversibles = array_reverse($this->reversibles);
        return static function($value) use ($reversibles) {
            foreach ($reversibles as $reversible) {
                $value = $reversible->getReversionClosure()($value);
            }
            return $value;
        };
    }
}
