<?php

namespace app\Http\Request;

interface Request
{
    public function getUri(): string;
}
