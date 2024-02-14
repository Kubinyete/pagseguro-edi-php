<?php

namespace Kubinyete\Edi\PagSeguro\Model\Pagination;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;
use Kubinyete\Edi\PagSeguro\Model\Movement\FinantialMovement;
use Kubinyete\Edi\PagSeguro\Model\Movement\TransactionalMovement;
use Kubinyete\Edi\PagSeguro\Model\Movement\FinantialAccountBalance;

class FinantialPage extends Page
{
    protected function schema(SchemaBuilder $schema)
    {
        parent::schema($schema);
        $schema->hasMany('detalhes', FinantialMovement::class);
        $schema->hasMany('saldos', FinantialAccountBalance::class);
    }

    /** @return array<FinantialMovement> */
    public function getDetails(): array
    {
        return $this->get('detalhes');
    }

    /** @return array<FinantialAccountBalance> */
    public function getAccountBalanceList(): array
    {
        return $this->get('saldos');
    }
}
