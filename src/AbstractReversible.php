<?php
declare(strict_types=1);
namespace CoStack\Reversible;

abstract class AbstractReversible implements Reversible
{
    public function execute($value)
    {
        return $this->getExecutionClosure()($value);
    }

    public function reverse($value)
    {
        return $this->getReversionClosure()($value);
    }

}
