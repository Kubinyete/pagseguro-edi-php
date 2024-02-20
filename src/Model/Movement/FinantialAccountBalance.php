<?php

namespace Kubinyete\Edi\PagSeguro\Model\Movement;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class FinantialAccountBalance extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->int("estabelecimento"); //: "136625414",
        $schema->int("tipo_evento"); //: "7",
        $schema->string("data_movimentacao"); //: "2023-11-15",
        $schema->float("valor_saldo"); //: "0.00",
    }

    public function getEstabelecimento(): int
    {
        return $this->get("estabelecimento");
    }

    public function getTipoEvento(): int
    {
        return $this->get("tipo_evento");
    }

    public function getDataMovimentacao(): string
    {
        return $this->get("data_movimentacao");
    }

    public function getValorSaldo(): float
    {
        return $this->get("valor_saldo");
    }
}
