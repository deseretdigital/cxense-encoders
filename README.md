# Cxense Encoders

Cxense requires custom parameters to be <= 20 characters. This library provides encoders for data
that may in original form not fit into this 20 character limit. Decoders are also provided.

## List of Supported Encoders

* MongoIdEncoder - Converts a 24 character Mongo ID to a 17 character string and back

## Interface

All encoders make use of a common interface that provides an `encode` and a `decode` method.

## Examples

```php
<?php

$encoder = new CxenseEncoders\MongoIdEncoder();

$encodedId = $encoder->encode('555cba723287777ccc0041b2');
$decodedId = $encoder->decode($encodedId);

```
