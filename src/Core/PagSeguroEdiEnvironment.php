<?php

namespace Kubinyete\Edi\PagSeguro\Core;

class PagSeguroEdiEnvironment extends Environment
{
    public static function production(): static
    {
        return new static('https://edi.api.pagbank.com.br/edi/v1');
    }
}
