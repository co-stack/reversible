<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Exception\InvalidArgumentTypeException;
use CoStack\Reversible\TypeLossy;
use function base64_decode;
use function base64_encode;
use function gettype;
use function is_scalar;

/**
 * Lossy
 */
class Base64Encoding extends AbstractReversible implements TypeLossy
{
    public function getExecutionClosure(): Closure
    {
        return function($value): string {
            if (!is_scalar($value)) {
                throw InvalidArgumentTypeException::create('value', 'scalar', gettype($value));
            }
            return base64_encode((string)$value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(string $value): string {
            return base64_decode($value, true);
        };
    }

}
