<?php

namespace Kubinyete\Edi\PagSeguro\Model\Token;

use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class TokenResponse extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->int('code');
        $schema->string('codeValue');
        $schema->string('message');
    }

    public function isOk(): bool
    {
        return $this->get('code') === 200;
    }
}
