<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Fixed;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function strlen;
use function substr;

class FixedPrefix extends AbstractReversible
{
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getExecutionClosure(): Closure
    {
        return function(string $value): string {
            return $this->prefix . $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(string $value): string {
            return substr($value, strlen($this->prefix));
        };
    }

}
