<?php
declare(strict_types=1);
namespace CoStack\Reversible;

use Closure;

interface Reversible
{
    public function getExecutionClosure(): Closure;

    public function getReversionClosure(): Closure;
}
