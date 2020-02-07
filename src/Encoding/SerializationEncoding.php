<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Exception\InvalidArgumentTypeException;
use function gettype;
use function is_array;
use function is_object;
use function is_scalar;
use function serialize;
use function unserialize;

class SerializationEncoding extends AbstractReversible
{
    public function getExecutionClosure(): Closure
    {
        return static function($value): string {
            if (!(is_array($value) || is_scalar($value) || is_object($value))) {
                throw InvalidArgumentTypeException::create('value', 'array|scalar|object', gettype($value));
            }
            return serialize($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value) {
            return unserialize($value);
        };
    }
}
