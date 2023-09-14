<?php

namespace Unit\Storage;

use app\Storage\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testSession()
    {
        global $_SESSION;

        $session = Session::getInstance();

        $session->setOptions(['set_from_options' => 'from_options_values']);
        $session->setOption('option', 'option_value');
        $session->save();

        $options = $session->getOptions();

        $this->assertEquals([
            'set_from_options' => 'from_options_values',
            'option' => 'option_value'
        ], $_SESSION);

        $this->assertEquals([
            'set_from_options' => 'from_options_values',
            'option' => 'option_value'
        ], $options);
    }
}
