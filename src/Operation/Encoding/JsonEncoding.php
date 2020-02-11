<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use CoStack\Reversible\Exception;
use CoStack\Reversible\Exception\InvalidArgumentTypeException;
use function gettype;
use function is_array;
use function is_scalar;
use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use const JSON_ERROR_NONE;

class JsonEncoding extends AbstractReversible
{
    public function getExecutionClosure(): Closure
    {
        return static function($value): string {
            if (!(is_array($value) || is_scalar($value))) {
                throw InvalidArgumentTypeException::create('value', 'array|scalar', gettype($value));
            }
            $value = json_encode($value);
            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new Exception(
                    'json_encode error: ' . json_last_error_msg()
                );
            }
            return $value;
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value) {
            $value = json_decode($value, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new Exception(
                    'json_decode error: ' . json_last_error_msg()
                );
            }
            return $value;
        };
    }
}
