<?php
declare(strict_types=1);
namespace CoStack\Reversible\Operation\Fixed;

use Closure;
use CoStack\Reversible\AbstractReversible;
use function strlen;
use function substr;

class FixedStringStripping extends AbstractReversible
{
    private $positions;
    private $string;

    public function __construct(string $string, array $positions)
    {
        $this->string = $string;
        $this->positions = $positions;
    }

    public function getExecutionClosure(): Closure
    {
        return function(string $input): string {
            $stripLength = strlen($this->string);
            $output = '';
            foreach ($this->positions as $position) {
                $output .= substr($input, 0, $position);
                $input = substr($input, $position + $stripLength);
            }
            return $output . $input;
        };
    }

    public function getReversionClosure(): Closure
    {
        return function(string $input): string {
            $output = '';
            foreach ($this->positions as $position) {
                $output .= substr($input, 0, $position);
                $output .= $this->string;
                $input = substr($input, $position);
            }
            return $output . $input;
        };
    }

}
