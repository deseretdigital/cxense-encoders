<?php

namespace CxenseEncoders;

/**
 * Standard interface for all encoders
 */
interface EncoderInterface
{
    /**
     * Encodes a value
     *
     * @param string $value
     *
     * @return string
     */
    public function encode($value);

    /**
     * Decodes a value
     *
     * @param string $value
     *
     * @return string
     */
    public function decode($value);
}
