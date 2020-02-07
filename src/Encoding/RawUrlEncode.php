<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function rawurldecode;
use function rawurlencode;

class RawUrlEncode extends AbstractReversible
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
