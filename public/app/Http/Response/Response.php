<?php

namespace app\Http\Response;

interface Response
{
    public function getContent(): string;

    /**
     * @return string[]
     */
    public function getHeaders(): array;
}
