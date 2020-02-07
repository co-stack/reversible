<?php
declare(strict_types=1);
namespace CoStack\Reversible;

use Closure;

interface Reversible
{
    public function execute($value);

    public function getExecutionClosure(): Closure;

    public function reverse($value);

    public function getReversionClosure(): Closure;
}
