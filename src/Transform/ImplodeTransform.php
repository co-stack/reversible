<?php
declare(strict_types=1);
namespace CoStack\Reversible\Transform;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Exception\ArrayIsNotSequentialException;
use CoStack\Reversible\TypeLossy;
use function explode;
use function implode;

class ImplodeTransform extends AbstractReversible implements TypeLossy
{
    /** @var string */
    private $delimiter;

    public function __construct(string $delimiter = '|')
    {
        $this->delimiter = $delimiter;
    }

    public function getExecutionClosure(): Closure
    {
        return function(array $value): string {
            if (!empty(array_filter(array_keys($value), 'is_string'))) {
                throw ArrayIsNotSequentialException::create(__METHOD__);
            }
            return implode($this->delimiter, $value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(string $value): array {
            return explode($this->delimiter, $value);
        };
    }

}
