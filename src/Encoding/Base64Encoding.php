<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\Exception\InvalidArgumentTypeException;
use CoStack\Reversible\Reversible;
use function base64_decode;
use function base64_encode;
use function explode;
use function gettype;
use function is_array;
use function is_scalar;
use function json_decode;
use function json_encode;

class Base64Encoding implements Reversible
{
    private const TYPE_ARRAY = 'array';
    private const TYPE_SCALAR = 'scalar';
    private const DELIMITER = '|';

    public function getExecutionClosure(): Closure
    {
        return static function($value): string {
            if (!(is_array($value) || is_scalar($value))) {
                throw InvalidArgumentTypeException::create('value', 'array|scalar', gettype($value));
            }
            $type = self::TYPE_SCALAR;
            if (is_array($value)) {
                $value = json_encode($value);
                $type = self::TYPE_ARRAY;
            }
            return $type . self::DELIMITER . base64_encode($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value) {
            [$type, $value] = explode(self::DELIMITER, $value, 2);
            $value = base64_decode($value);
            if ($type === self::TYPE_ARRAY) {
                $value = json_decode($value, true);
            }
            return $value;
        };
    }

}
