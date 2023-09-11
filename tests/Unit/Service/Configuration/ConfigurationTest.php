<?php

namespace Unit\Service\Configuration;

use PHPUnit\Framework\TestCase;
use app\Service\Configuration\Configuration;

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
        $publishOptionName = (new \ReflectionClassConstant(Configuration::class, 'PUBLISH_OPTION_TIMESTAMP'))->getValue();
        $storage = $this->getStorage([
            $publishOptionName => time() - 1
        ]);

        $configuration = new Configuration($storage);

        $this->assertTrue($configuration->isPublish());
    }

    public function testIsNotPublished()
    {
        $publishOptionName = (new \ReflectionClassConstant(Configuration::class, 'PUBLISH_OPTION_TIMESTAMP'))->getValue();
        $storage = $this->getStorage([
            $publishOptionName => time() + 1
        ]);

        $configuration = new Configuration($storage);

        $this->assertFalse($configuration->isPublish());
    }

    public function testArrayAccessInterface()
    {
        $storage = $this->getStorage([
            'available_value' => 'value',
            'for_unset' => true
        ]);
        $storage->shouldReceive('setOptions');
        $storage->shouldReceive('save')->andReturn(true);

        $configuration = new Configuration($storage);

        $this->assertTrue($configuration->isSet('available_value'));
        $this->assertFalse($configuration->isSet('unavailable_value'));

        $this->assertTrue($configuration->offsetExists('available_value'));
        $this->assertFalse($configuration->offsetExists('unavailable_value'));

        $this->assertTrue($configuration->offsetExists('for_unset'));
        $configuration->offsetUnset('for_unset');
        $this->assertFalse($configuration->offsetExists('for_unset'));

        $this->assertEquals('value', $configuration->offsetGet('available_value'));
        $this->assertEquals(null, $configuration->offsetGet('unavailable_value'));

        $configuration->setOption('additional_option', 'other_value');
        $configuration->offsetSet(null, 'nullable_value');
        $configuration->offsetSet('offset_key', 'offset_value');

        $this->assertEquals([
            'nullable_value',
            'available_value' => 'value',
            'additional_option' => 'other_value',
            'offset_key' => 'offset_value'
        ], $configuration->getOptions());

        $configuration->save();
    }

    private function getStorage(array $options): \app\Storage\Configuration
    {
        $storage = \Mockery::mock(\app\Storage\Configuration::class);

        $storage->shouldReceive('getOptions')
            ->andReturn($options);

        return $storage;
    }
}
