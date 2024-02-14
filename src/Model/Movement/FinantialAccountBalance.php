<?php

namespace Kubinyete\Edi\PagSeguro\Model\Movement;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class FinantialAccountBalance extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->string("estabelecimento"); //: "136625414",
        $schema->string("tipo_evento"); //: "7",
        $schema->string("data_movimentacao"); //: "2023-11-15",
        $schema->string("valor_saldo"); //: "0.00",
    }

    public function getEstabelecimento(): string
    {
        return $this->get("estabelecimento");
    }

    public function getTipoEvento(): string
    {
        return $this->get("tipo_evento");
    }

    public function getDataMovimentacao(): string
    {
        return $this->get("data_movimentacao");
    }

    public function getValorSaldo(): string
    {
        return $this->get("valor_saldo");
    }
}
