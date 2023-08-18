<?php

namespace app\Http\Response;

class ProtectedPage implements Response
{
    public function getContent(): string
    {
        return '';
    }

    public function getHeaders(): array
    {
        return [];
    }
}
