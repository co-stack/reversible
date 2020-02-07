<?php
declare(strict_types=1);
namespace CoStack\Reversible\Exception;

use CoStack\Reversible\Exception;
use function sprintf;

class ArrayIsNotSequentialException extends Exception
{
    public const CODE = 1581089760;
    public const MESSAGE = 'The array passed to "%s" is not sequential (it has associative keys).';

    public static function create(string $method): ArrayIsNotSequentialException
    {
        return new self(sprintf(self::MESSAGE, $method), self::CODE);
    }
}
