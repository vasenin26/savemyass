<?php

namespace Unit\Storage;

use app\Storage\StorageFile;
use PHPUnit\Framework\TestCase;

class ConfigurationFileTest extends TestCase
{
    public function testCreateStorage()
    {
        $storage = new StorageFile('test.data');

        $this->assertInstanceOf(StorageFile::class, $storage);
    }

    public function testSaveOptions()
    {
        $storage = new StorageFile('test.data');

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

        $storage = new StorageFile($storageFileName);
        $storage->setOptions($options);
        $storage->save();

        $storage2 = new StorageFile($storageFileName);
        $result = $storage2->getOptions();

        $this->assertEquals('test', $storage2->getOption('string_value'));
        $this->assertEquals($options, $result);

        $storage2->setOption('option_from_set', 'from_set');
        $this->assertEquals('from_set', $storage2->getOption('option_from_set'));

        $storage2->clear();
    }
}
