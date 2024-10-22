<?php

declare(strict_types=1);

/*
 * This file is part of package assoconnect/php-excel-encoder
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AssoConnect\Serializer\Encoder\Tests;

use AssoConnect\Serializer\Encoder\ExcelEncoder;
use PHPUnit\Framework\TestCase;

/**
 * @author Joanis ROUANET
 *
 * @internal
 *
 * @covers \AssoConnect\Serializer\Encoder\ExcelEncoder
 */
final class ExcelEncoderTest extends TestCase
{
    private ExcelEncoder $encoder;

    /**
     * Set up test.
     */
    protected function setUp(): void
    {
        $this->encoder = new ExcelEncoder();
    }

    /**
     * @dataProvider provideDataEncoding
     */
    public function testEncode(string $format): void
    {
        self::expectNotToPerformAssertions();
        $this->encoder->encode($this->getInitialData(), $format);
    }

    /**
     * @dataProvider provideDataDecoding
     *
     * @param mixed[] $result
     */
    public function testDecode(string $file, string $format, array $result): void
    {
        static::assertSame($result, $this->encoder->decode((string) file_get_contents($file), $format));
    }

    /**
     * @return string[][]
     */
    public static function provideDataEncoding(): array
    {
        return [
            [ExcelEncoder::XLS],
            [ExcelEncoder::XLSX],
        ];
    }


    public static function provideDataDecoding(): array
    {
        $decodingData = [
            'Sheet_0' => [
                [
                    'bool' => 0,
                    'int' => 1,
                    'float' => 1.618,
                    'string' => 'Hello',
                    'object.date' => '2000-01-01 13:37:00.000000',
                    'object.timezone_type' => 3,
                    'object.timezone' => 'Europe/Berlin',
                    'array.bool' => 1,
                    'array.int' => 3,
                    'array.float' => 3.14,
                    'array.string' => 'World',
                    'array.object.date' => '2000-01-01 13:37:00.000000',
                    'array.object.timezone_type' => 3,
                    'array.object.timezone' => 'Europe/Berlin',
                    'array.array.0' => 'again',
                ],
            ],
            'Feuil1' => [
                [
                    'bool' => 0,
                    'int' => 1,
                    'float' => 1.618,
                    'string' => 'Hello',
                    'object.date' => '2000-01-01 13:37:00.000000',
                    'object.timezone_type' => 3,
                    'object.timezone' => 'Europe/Berlin',
                    'array.bool' => 1,
                    'array.int' => 3,
                    'array.float' => 3.14,
                    'array.string' => 'World',
                    'array.object.date' => '2000-01-01 13:37:00.000000',
                    'array.object.timezone_type' => 3,
                    'array.object.timezone' => 'Europe/Berlin',
                    'array.array.0' => 'again',
                ],
            ],
        ];

        return [
            [__DIR__ . '/Resources/encoded.xls', ExcelEncoder::XLS, $decodingData],
            [__DIR__ . '/Resources/encoded.xlsx', ExcelEncoder::XLSX, $decodingData],
        ];
    }

    /**
     * @internal
     */
    private function getInitialData(): array
    {
        return [
            'Sheet_0' => [
                [
                    'bool' => true,
                    'int' => 2,
                    'float' => 2.718,
                    'string' => 'Bonjour',
                    'object' => new \DateTime('2021-05-21 10:15:00'),
                    'array' => [
                        'bool' => false,
                        'int' => 5,
                        'float' => 2.71,
                        'string' => 'Monde',
                        'object' => new \DateTime('2021-05-21 10:15:00'),
                        'array' => [
                            'encore',
                        ],
                    ],
                ],
            ],
            'Feuil1' => [
                [
                    'bool' => false,
                    'int' => 3,
                    'float' => 3.141,
                    'string' => 'Salut',
                    'object' => new \DateTime('1999-12-31 23:59:59'),
                    'array' => [
                        'bool' => true,
                        'int' => 7,
                        'float' => 1.61,
                        'string' => 'Terre',
                        'object' => new \DateTime('1999-12-31 23:59:59'),
                        'array' => [
                            'toujours',
                        ],
                    ],
                ],
            ],
        ];
    }
}
