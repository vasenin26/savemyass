<?php

namespace app\Service\Publisher;

use app\Http\Response\Response;

interface Publisher
{
    public function getPublicPage(): Response;
    public function publish(): void;
}
