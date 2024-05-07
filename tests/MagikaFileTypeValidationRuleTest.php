<?php

namespace Jobins\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Jobins\MagikaFileValidator\MagikaFileValidatorServiceProvider;
use Jobins\MagikaFileValidator\Rules\MagikaFileTypeValidationRule;
use Orchestra\Testbench\TestCase;

class MagikaFileTypeValidationRuleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Manually setting configuration for testing
        Config::set('magika.magika_binary_path', 'bin/macos/magika');
    }

    protected function testGetPackageProviders($app): array
    {
        return [MagikaFileValidatorServiceProvider::class];
    }

    /** @dataProvider provideDataSet * */
    public function testValidationPassesWithCorrectFileType($formats, $filePath, $expectation)
    {
        $filePath = __DIR__.$filePath;
        $file     = new UploadedFile($filePath, basename($filePath));

        $result = (new MagikaFileTypeValidationRule($formats))->passes('file', $file);

        $this->assertEquals($result, $expectation);
    }

    /**
     * @return array[]
     */
    public static function provideDataSet(): array
    {
        return [
            [['pdf'], '/Fixtures/pdf.pdf', true],
            [['png'], '/Fixtures/image.png', true],
            [['png'], '/Fixtures/pdf.png', false],
            [['pdf'], '/Fixtures/image.pdf', false]
        ];
    }
}
