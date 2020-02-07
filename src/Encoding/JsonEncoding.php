<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\Exception\InvalidArgumentTypeException;
use CoStack\Reversible\Reversible;
use function gettype;
use function is_array;
use function is_scalar;
use function json_decode;
use function json_encode;

class JsonEncoding implements Reversible
{
    public function getExecutionClosure(): Closure
    {
        return static function($value): string {
            if (!(is_array($value) || is_scalar($value))) {
                throw InvalidArgumentTypeException::create('value', 'array|scalar', gettype($value));
            }
            return json_encode($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value) {
            return json_decode($value, true);
        };
    }
}
