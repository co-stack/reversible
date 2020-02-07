<?php
declare(strict_types=1);
namespace CoStack\Reversible\Exception;

use CoStack\Reversible\Exception;
use function sprintf;

class InvalidArgumentTypeException extends Exception
{
    public const CODE = 1581073983;
    public const MESSAGE = 'Argument "%s" is expected to be of type "%s", "%s" given';

    public static function create(string $name, string $expected, string $actual): InvalidArgumentTypeException
    {
        return new self(sprintf(self::MESSAGE, $name, $expected, $actual), self::CODE);
    }
}
