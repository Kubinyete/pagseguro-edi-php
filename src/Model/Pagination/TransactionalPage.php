<?php

namespace Kubinyete\Edi\PagSeguro\Model\Pagination;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;
use Kubinyete\Edi\PagSeguro\Model\Movement\TransactionalMovement;

class TransactionalPage extends Page
{
    protected function schema(SchemaBuilder $schema)
    {
        parent::schema($schema);
        $schema->hasMany('detalhes', TransactionalMovement::class);
    }

    /** @return array<TransactionalMovement> */
    public function getDetails(): array
    {
        return $this->get('detalhes');
    }
}
