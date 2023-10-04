<?php

namespace Unit\Utils\Converter;

use app\Utils\Converter\StringConverter;
use PHPUnit\Framework\TestCase;

class StringConverterTest extends TestCase
{
    /**
     * @dataProvider convertVariantsProvider
     */
    public function testConvert(mixed $value, string $expected): void
    {
        $converter = new StringConverter();
        $result = $converter->convert($value);

        $this->assertTrue($expected === $result);
    }

    /**
     * @dataProvider extractVariantsProvider
     */
    public function testExtract(null|string $value, mixed $expected): void
    {
        $converter = new StringConverter();
        $result = $converter->extract($value);

        $this->assertTrue($expected === $result);
    }

    public function testConvertException(): void
    {
        $converter = new StringConverter();
        $this->expectException(\ErrorException::class);

        $value = new class {
            private $foo = 'bar';
        };

        $converter->convert($value);
    }

    /**
     * @dataProvider convenrtEqualProvider
     */
    public function testConvertEqual($value): void
    {
        $converter = new StringConverter();
        $converted = $converter->convert($value);
        $restored = $converter->extract($converted);

        var_dump($value, $converted, $restored);

        $this->assertEquals($value, $restored);
    }

    public function extractVariantsProvider()
    {
        return [
            'true' => ['true', true],
            'false' => ['false', false],
            '0' => ['0', 0],
            '1' => ['1', 1],
            'null' => [null, ''],
            'empty' => ['', null]
        ];
    }

    public function convertVariantsProvider()
    {
        return [
            'true' => [true, 'true'],
            'false' => [false, 'false'],
            '0' => [0, '0'],
            '1' => [1, '1'],
            'null' => [null, '']
        ];
    }

    public function convenrtEqualProvider()
    {
        return [
            'true' => [true],
            'false' => [false],
            'zero string' => ['0'],
            'number string' => ['1'],
            'null' => [null],
            'simple string' => ['string'],
            'multiline string' => ["multiline \n string"],
        ];
    }
}