<?php

namespace Unit\Service\Publisher;

use app\Http\Response\HtmlPage;
use app\Service\Publisher\DataPublisher;
use PHPUnit\Framework\TestCase;

class DataPublisherTest extends TestCase
{
    public function testGetPublicPage()
    {
        $dp = new DataPublisher();
        $page = $dp->getPublicPage();

        $this->assertInstanceOf(HtmlPage::class, $page);
    }

    public function testPublish()
    {
        //TODO: Implement testPublish() method.
        $dp = new DataPublisher();
        $dp->publish();

        $this->assertTrue(true);
    }
}
