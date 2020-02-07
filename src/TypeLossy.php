<?php
declare(strict_types=1);
namespace CoStack\Reversible;

/**
 * Interface to mark reversible functions that are not 100% idempotent.
 * Reversible implementing this interface indicate that data types may be lost during conversion.
 * Any scalar value will be a string after function reversion.
 */
interface TypeLossy
{
}
