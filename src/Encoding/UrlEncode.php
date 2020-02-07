<?php
declare(strict_types=1);
namespace CoStack\Reversible\Encoding;

use Closure;
use CoStack\Reversible\Reversible;
use function urldecode;
use function urlencode;

class UrlEncode implements Reversible
{
    public function getExecutionClosure(): Closure
    {
        return static function(string $value): string {
            return urlencode($value);
        };
    }

    public function getReversionClosure(): Closure
    {
        return static function(string $value): string {
            return urldecode($value);
        };
    }
}
