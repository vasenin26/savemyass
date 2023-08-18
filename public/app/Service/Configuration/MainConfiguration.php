<?php

namespace app\Service\Configuration;

interface MainConfiguration
{
    public function isPublish(): bool;
    public function isConfigured(): bool;
}
