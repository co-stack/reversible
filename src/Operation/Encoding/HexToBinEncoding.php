<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Encoding;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function bin2hex;
use function hex2bin;

class HexToBinEncoding extends AbstractReversible
{
    public function getExecutionClosure(): Closure
    {
        return function(string $input): string {
            return hex2bin($input);
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(string $input): string {
            return bin2hex($input);
        };
    }

}
