<?php

namespace CxenseEncoders;

/**
 * Encodes Mongo IDs so they can be used with Cxense custom parameters which require
 * a string less than 20 characters.
 *
 * Also provides a decode method
 */
class MongoIdEncoder implements EncoderInterface
{
    /**
     * Alphabet used in encoding to base62
     *
     * @var string
     */
    protected $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Encodes a mongo id to a shorter id for use in cXense etc
     *
     * @param string $mongoId
     *
     * @return string
     */
    public function encode($mongoId)
    {
        // We have to split the mongoId in half or converting to decimal gives us
        // a float in scientific notation that fails in encoding
        $decimalArray = array_map('hexdec', str_split($mongoId, 12));
        $encodedArray = array_map([$this, 'baseEncode'], $decimalArray);
        $encodedId = implode('.', $encodedArray);
        return $encodedId;
    }

    /**
     * Decodes an encoded id to the original mongo id
     *
     * @param string $encodedId
     *
     * @return string
     */
    public function decode($encodedId)
    {
        $encodedArray = explode('.', $encodedId);
        $decimalArray = array_map([$this, 'baseDecode'], $encodedArray);
        $mongoId = implode(array_map('dechex', $decimalArray));
        return $mongoId;
    }

    //########################
    // Borrowed from https://github.com/deprecat/base62
    //########################

    /**
     * Decode a string to a integer.
     *
     * @param string $value
     * @param int $b
     *
     * @return int
     */
    protected function baseDecode($value, $b = 62)
    {
        $limit = strlen($value);
        $result = strpos($this->alphabet, $value[0]);
        for ($i = 1; $i < $limit; $i++) {
            $result = $b * $result + strpos($this->alphabet, $value[$i]);
        }
        return $result;
    }
    /**
     * Encode an integer to a string.
     *
     * @param int $value
     * @param int $b
     *
     * @return string
     */
    protected function baseEncode($value, $b = 62)
    {
        $r = (int) $value % $b;
        $result = $this->alphabet[$r];
        $q = floor((int) $value / $b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q / $b);
            $result = $this->alphabet[$r].$result;
        }
        return $result;
    }
}
