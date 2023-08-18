<?php

namespace app\Service\Publisher;

use app\Http\Response\Response;

interface DataPublisher
{
    public function getPublicPage(): Response;
    public function publish(): void;
}
