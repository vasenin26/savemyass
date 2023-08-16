<?php

namespace Unit\Storage;

use app\Storage\ConfigurationFile;
use PHPUnit\Framework\TestCase;

class ConfigurationFileTest extends TestCase
{
    public function testCreateStorage()
    {
        $storage = new ConfigurationFile('test.data');

        $this->assertInstanceOf(ConfigurationFile::class, $storage);
    }

    public function testSaveOptions()
    {
        $storage = new ConfigurationFile('test.data');

        $storage->save();
        $storage->clear();

        $this->assertTrue(true);
    }

    public function testSaveAndRead()
    {
        $storageFileName = 'test.data';

        $options = [
            'integer_value' => 1,
            'zero_value' => 0,
            'boolean_value_true' => true,
            'boolean_value_false' => false,
            'string_value' => 'test',
            'null_value' => null
        ];

        $storage = new ConfigurationFile($storageFileName);
        $storage->setOptions($options);
        $storage->save();

        $storage2 = new ConfigurationFile($storageFileName);
        $result = $storage2->getOptions();

        $this->assertEquals($options, $result);

        $storage2->clear();
    }
}
