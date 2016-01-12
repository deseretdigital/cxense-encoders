<?php

namespace CxenseEncoders\Tests\MongoIdTest;

use CxenseEncoders\MongoIdEncoder;

/**
 * @coversDefaultClass \CxenseEncoders\MongoIdEncoder
 */
class MongoIdEncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers ::encode
     * @covers ::baseEncode
     *
     * @dataProvider mongoIdProvider
     */
    public function encodeMongoIdReturns20CharactersOrLess($mongoId)
    {
        $helper = new MongoIdEncoder();
        $encodedId = $helper->encode($mongoId);
        $this->assertLessThanOrEqual(20, strlen($encodedId));
    }


    /**
     * @test
     * @covers ::decode
     * @covers ::baseDecode
     *
     * @dataProvider mongoIdProvider
     */
    public function decodingGivesOriginalEncodedValue($originalId)
    {
        $helper = new MongoIdEncoder();
        $encodedValue = $helper->encode($originalId);
        $decodedValue = $helper->decode($encodedValue);
        $this->assertEquals($originalId, $decodedValue);
    }

    public function mongoIdProvider()
    {
        return [
            ['123456789a123456789b1234'],
            ['5582ffa65f5e88ac35eee631'],
            ['560055a05f5e88787ca10a6c'],
            ['555cba723287777ccc0041b2'],
            ['557e42c5e92e3cdb100b636a'],
            ['558b1e03e92e3c8a4eba922b'],
        ];
    }
}
