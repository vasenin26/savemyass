<?php

namespace app\Service\Configuration;

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Reflection;

class ConfigurationTest extends TestCase
{
    public function testCheckFullNotConfigured()
    {
        $storage = $this->getStorage([]);

        $configuration = new Configuration($storage);

        $this->assertFalse($configuration->isConfigured());
    }

    public function testCheckFullConfigured()
    {
        $requiredOptions = new \ReflectionClassConstant(Configuration::class, 'REQUIRE_OPTIONS');
        $options = array_flip($requiredOptions->getValue());
        $storage = $this->getStorage($options);

        $configuration = new Configuration($storage);

        $this->assertTrue($configuration->isConfigured());
    }

    public function testIsPublished()
    {
        $publishOptionName = (new \ReflectionClassConstant(Configuration::class, 'PUBLISH_OPTION_NAME'))->getValue();
        $storage = $this->getStorage([
            $publishOptionName => time() - 1
        ]);

        $configuration = new Configuration($storage);

        $this->assertTrue($configuration->isPublish());
    }

    public function testIsNotPublished()
    {
        $publishOptionName = (new \ReflectionClassConstant(Configuration::class, 'PUBLISH_OPTION_NAME'))->getValue();
        $storage = $this->getStorage([
            $publishOptionName => time() + 1
        ]);

        $configuration = new Configuration($storage);

        $this->assertFalse($configuration->isPublish());
    }

    private function getStorage(array $options): \app\Storage\Configuration
    {
        $storage = \Mockery::mock(\app\Storage\Configuration::class);

        $storage->shouldReceive('getOptions')
            ->andReturn($options);

        return $storage;
    }
}
