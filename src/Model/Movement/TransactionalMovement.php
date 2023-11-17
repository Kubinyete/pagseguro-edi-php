<?php

namespace Kubinyete\Edi\PagSeguro\Model\Movement;

use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class TransactionalMovement extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->string("movimento_api_codigo"); //: "0B423E3124BC4C11226DCA383231C27C",
        $schema->string("tipo_registro"); //: "1",
        $schema->string("estabelecimento"); //: "136625414",
        $schema->string("data_inicial_transacao"); //: "2023-11-12",
        $schema->string("hora_inicial_transacao"); //: "22:17:25",
        $schema->string("data_venda_ajuste"); //: "2023-11-14",
        $schema->string("hora_venda_ajuste"); //: "05:51:55",
        $schema->string("tipo_evento"); //: "1",
        $schema->string("tipo_transacao"); //: "1",
        $schema->string("codigo_transacao"); //: "30E5AE0A6B01455A8262040359F88E89",
        $schema->string("codigo_venda"); //: "7326655",
        $schema->float("valor_total_transacao"); //: 663.66,
        $schema->float("valor_parcela"); //: 662.18,
        $schema->string("pagamento_prazo"); //: "U",
        $schema->string("plano"); //: "1 ",
        $schema->string("parcela"); //: "1",
        $schema->string("quantidade_parcela"); //: "0",
        $schema->date("data_prevista_pagamento", format: 'Y-m-d'); //: "2023-11-15",
        $schema->float("taxa_parcela_comprador")->nullable(); //: null,
        $schema->float("tarifa_boleto_compra")->nullable(); //: null,
        $schema->float("valor_original_transacao")->nullable(); //: 663.66,
        $schema->float("taxa_parcela_vendedor")->nullable(); //: null,
        $schema->float("taxa_intermediacao")->nullable(); //: 0.0,
        $schema->float("tarifa_intermediacao")->nullable(); //: 1.48,
        $schema->float("tarifa_boleto_vendedor")->nullable(); //: 0.0,
        $schema->float("taxa_rep_aplicacao")->nullable(); //: null,
        $schema->float("valor_liquido_transacao"); //: 662.18,
        $schema->string("status_pagamento"); //: "1",
        $schema->string("meio_pagamento"); //: "2",
        $schema->string("instituicao_financeira"); //: "BOLETO",
        $schema->string("canal_entrada"); //: "W",
        $schema->string("leitor"); //: "",
        $schema->string("meio_captura"); //: "3",
        $schema->string("num_logico"); //: "",
        $schema->string("nsu"); //: "",
        $schema->string("cartao_bin"); //: "      ",
        $schema->string("cartao_holder"); //: "    ",
        $schema->string("codigo_autorizacao"); //: "",
        $schema->string("codigo_cv"); //: "",
        $schema->string("numero_serie_leitor"); //: "        ",
        $schema->string("tx_id")->nullable(); //: null
    }

    public function getMovimentoApiCodigo(): string
    {
        return $this->get('movimento_api_codigo');
    }

    public function getTipoRegistro(): string
    {
        return $this->get('tipo_registro');
    }

    public function getEstabelecimento(): string
    {
        return $this->get('estabelecimento');
    }

    public function getDataInicialTransacao(): string
    {
        return $this->get('data_inicial_transacao');
    }

    public function getHoraInicialTransacao(): string
    {
        return $this->get('hora_inicial_transacao');
    }

    public function getDataVendaAjuste(): string
    {
        return $this->get('data_venda_ajuste');
    }

    public function getHoraVendaAjuste(): string
    {
        return $this->get('hora_venda_ajuste');
    }

    public function getTipoEvento(): string
    {
        return $this->get('tipo_evento');
    }

    public function getTipoTransacao(): string
    {
        return $this->get('tipo_transacao');
    }

    public function getCodigoTransacao(): string
    {
        return $this->get('codigo_transacao');
    }

    public function getCodigoVenda(): string
    {
        return $this->get('codigo_venda');
    }

    public function getValorTotalTransacao(): float
    {
        return $this->get('valor_total_transacao');
    }

    public function getValorParcela(): float
    {
        return $this->get('valor_parcela');
    }

    public function getPagamentoPrazo(): string
    {
        return $this->get('pagamento_prazo');
    }

    public function getPlano(): string
    {
        return $this->get('plano');
    }

    public function getParcela(): string
    {
        return $this->get('parcela');
    }

    public function getQuantidadeParcela(): string
    {
        return $this->get('quantidade_parcela');
    }

    public function getDataPrevistaPagamento(): string
    {
        return $this->get('data_prevista_pagamento');
    }

    public function getTaxaParcelaComprador(): ?float
    {
        return $this->get('taxa_parcela_comprador');
    }

    public function getTarifaBoletoCompra(): ?float
    {
        return $this->get('tarifa_boleto_compra');
    }

    public function getValorOriginalTransacao(): ?float
    {
        return $this->get('valor_original_transacao');
    }

    public function getTaxaParcelaVendedor(): ?float
    {
        return $this->get('taxa_parcela_vendedor');
    }

    public function getTaxaIntermediacao(): ?float
    {
        return $this->get('taxa_intermediacao');
    }

    public function getTarifaIntermediacao(): ?float
    {
        return $this->get('tarifa_intermediacao');
    }

    public function getTarifaBoletoVendedor(): ?float
    {
        return $this->get('tarifa_boleto_vendedor');
    }

    public function getTaxaRepAplicacao(): ?float
    {
        return $this->get('taxa_rep_aplicacao');
    }

    public function getValorLiquidoTransacao(): float
    {
        return $this->get('valor_liquido_transacao');
    }

    public function getStatusPagamento(): string
    {
        return $this->get('status_pagamento');
    }

    public function getMeioPagamento(): string
    {
        return $this->get('meio_pagamento');
    }

    public function getInstituicaoFinanceira(): string
    {
        return $this->get('instituicao_financeira');
    }

    public function getCanalEntrada(): string
    {
        return $this->get('canal_entrada');
    }

    public function getLeitor(): string
    {
        return $this->get('leitor');
    }

    public function getMeioCaptura(): string
    {
        return $this->get('meio_captura');
    }

    public function getNumLogico(): string
    {
        return $this->get('num_logico');
    }

    public function getNsu(): string
    {
        return $this->get('nsu');
    }

    public function getCartaoBin(): string
    {
        return $this->get('cartao_bin');
    }

    public function getCartaoHolder(): string
    {
        return $this->get('cartao_holder');
    }

    public function getCodigoAutorizacao(): string
    {
        return $this->get('codigo_autorizacao');
    }

    public function getCodigoCv(): string
    {
        return $this->get('codigo_cv');
    }

    public function getNumeroSerieLeitor(): string
    {
        return $this->get('numero_serie_leitor');
    }

    public function getTxId(): string
    {
        return $this->get('tx_id');
    }
}
