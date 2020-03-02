# co-stack/reversible - Reversible functions for PHP

## What is a reversible function

A reversible function is a function that can be executed forwards and backwards (reverted).
They are side effect free (idempotent) and stateless.

These functions are especially useful for transport encoding, persistence mapping, encryption and many other use cases.

## Notice

Some encodings are not fully idempotent, like `Base64Encoding`. The `base64_encode` function does not preserve data types (int, float, bool).
Implementations of `Reversible` that may not be fully idempotent implement the `Lossy` interface.

## Examples

I have prepared some useful examples for you, which show the versatility of this package

### Scalar value send over the air

On System A:
```php

// System A
$input = random_bytes(256);
$encoding = new \CoStack\Reversible\Encoding\Base64Encoding();
$output = $encoding->execute($input);

// System B
$encoding = new \CoStack\Reversible\Encoding\Base64Encoding();
$restoredInput = $encoding->reverse($output);
// $restoredInput is exactly $input what was generated on System A
```

### Associative array transportation via string without serialization

```php
 // Shared Library
 function getPipe(): \CoStack\Reversible\Applicable\ReversiblePipe {
    $pipe = new \CoStack\Reversible\Applicable\ReversiblePipe();
    $pipe->enqueue(new \CoStack\Reversible\Operation\Mapping\ArrayKeyMapping(['key1', 'key2', 'payload']));
    $pipe->enqueue(new \CoStack\Reversible\Applicable\ApplyOnArrayValueRecursively(new \CoStack\Reversible\Encoding\Base64Encoding()));
    $pipe->enqueue(new \CoStack\Reversible\Operation\Transform\ImplodeTransform());
    return $pipe;
}
 
// System A
$array = [
    'key1' => 1,
    'key2' => 'value',
    'payload' => uniqid(),
];
$pipe = getPipe();
$safeEncodedObject = $pipe->execute($array);

// The string will contain base64 encoded values, imploded with "|". There are no associative keys in the string because they have been replaced by the ArrayKeyMapping

// System B
$pipe = getPipe();
$array = $pipe->reverse($safeEncodedObject);
 ```
Please notice that `ImplodeTransform` is lossy because `explode(',', implode(',', [2])) === ['2']` (an integer will become a string).

### Object transportation via problematic medium (e.g. get parameter)

```php
// Shared Library
function getPipe(): \CoStack\Reversible\Applicable\ReversiblePipe {
    $pipe = new \CoStack\Reversible\Applicable\ReversiblePipe();
    $pipe->enqueue(new \CoStack\Reversible\Encoding\SerializationEncoding());
    $pipe->enqueue(new \CoStack\Reversible\Encoding\UrlEncode());
    return $pipe;
}

// System A
$object = new SplFileInfo('file.txt');
$pipe = getPipe();
$safeEncodedObject = $pipe->execute($object);

// System B
$pipe = getPipe();
$object = $pipe->reverse($safeEncodedObject);
```

### UUIDv4 to binary and back (e.g. for persisting uuid as binary in databases)

```php

$uuid = gen_uuid();

$uuidToBinary = new \CoStack\Reversible\Applicable\ReversiblePipe();
$uuidToBinary->enqueue(new \CoStack\Reversible\Operation\Fixed\FixedStringStripping('-', [8, 4, 4, 4]));
$uuidToBinary->enqueue(new \CoStack\Reversible\Operation\Encoding\HexToBinEncoding());

$binary = $uuidToBinary->execute($uuid);
// Persist binary uuid in DB

// Select binary uuid from DB and convert to readable string again
$uuidAgain = $uuidToBinary->reverse($binary);
```
