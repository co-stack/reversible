<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\Reversible;
use function rawurldecode;
use function rawurlencode;

class RawUrlEncode implements Reversible
{
    public function getExecutionClosure(): Closure
    {
        return static function(string $value): string {
            return rawurlencode($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value): string {
            return rawurldecode($value);
        };
    }
}
