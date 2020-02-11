<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function urldecode;
use function urlencode;

class UrlEncode extends AbstractReversible
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
