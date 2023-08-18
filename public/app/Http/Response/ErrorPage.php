<?php

namespace app\Http\Response;

class ErrorPage implements Response
{
    public function __construct(private \Exception $e)
    {
    }

    public function getContent(): string
    {
        return $this->e->getMessage();
    }

    public function getHeaders(): array
    {
        return [];
    }
}
