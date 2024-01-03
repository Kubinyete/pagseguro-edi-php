# <img align="top" src="https://assets.pagseguro.com.br/ps-bootstrap/v7.3.1/svg/pagbank/logo-pagbank.svg" width="165"> **EDI** for PHP

**pt-BR**: Uma biblioteca simples e direta para carregar sequencialmente dados do EDI da adquirente [PagSeguro](https://pagseguro.uol.com.br/)

**en-US**: A straightfoward library for sequential loading of EDI entries from [PagSeguro](https://pagseguro.uol.com.br/)

***NOTA**: Este guia está primariamente em inglês, caso haja necessidade, será adicionado uma versão em pt-BR no futuro.*

## Installation

This package is provided via packagist.org, you can install it directly using the following command:

```sh
composer require kubinyete/pagseguro-edi
```

Currently, only PHP versions 8.0 or greater are supported/tested, if you currently need support for older versions, we strongly
advice you to test it yourself and then create a pull request to merge any needed changes, any feedback is appreciated.

## Usage

First and foremost, this library is a simple webservice client designed to be used for sequential reading, this will
speed up your development time as any object, attribute mapping, data fetching and pagination mechanism has already
been implemented.

You can start right away by using the following code snippet:
```php
require_once 'vendor/autoload.php';

// Provided user
$credentialsUsername = getenv('USER');
// Provider secret token
$credentialsToken = getenv('TOKEN');

// Selected environment (production only)
$environment = \Kubinyete\Edi\PagSeguro\Core\PagSeguroEdiEnvironment::production();
// Selected EDI version (prefer latest)
$version = \Kubinyete\Edi\PagSeguro\Core\PagSeguroEdiClient::VERSION_LATEST;

$client = new \Kubinyete\Edi\PagSeguro\Core\PagSeguroEdiClient(
    env: $environment, 
    clientId: $credentialsUsername, token: $credentialsToken, 
    version: $version
);
```

### Fetching transactional movements

```php
// Creates a new paginator for any transactional movements from today, fetching every page with size 500
$paginator = $client->getTransactionalMovements(date: new DateTime('now'), pageSize: 500);

// Iterating over every page available
foreach ($paginator as $item) {
    // You can also manually configure or extract attributes from our paginator object
    echo "Found movement code {$item->getMovimentoApiCodigo()} on page {$paginator->getPage()}/{$paginator->getTotalPages()}" . PHP_EOL;
}
```

You can also manually fetch single pages or manually increment if necessary

```php
// Manually fetching first page
$paginator->setPage(1);
$items = $paginator-getItems();

// Increment +1 page
$paginator->incrementPage();
$items = $paginator-getItems();

// Decrement -1 page
$paginator->decrementPage();
$items = $paginator-getItems();

// Manually iterating (without an iterator)
while ($items = $paginator->nextItems()) {
    echo "Found movement code {$item->getMovimentoApiCodigo()} on page {$paginator->getPage()}/{$paginator->getTotalPages()}" . PHP_EOL;
}
```

### Fetching finantial movements

```php
// Creates a new paginator for any finantial movements from today, fetching every page with size 500
$paginator = $client->getFinantialMovements(date: new DateTime('now'), pageSize: 500);

// Iterating over every page available
foreach ($paginator as $item) {
    // You can also manually configure or extract attributes from our paginator object
    echo "Found movement code {$item->getMovimentoApiCodigo()} on page {$paginator->getPage()}/{$paginator->getTotalPages()}" . PHP_EOL;
}
```

## Supported movement types
### Transactional

| Attribute name | Type | Method
| --- | --- | ---
| movimento_api_codigo | string | `TransactionalMovement::getMovimentoApiCodigo`
| tipo_registro | string | `TransactionalMovement::getTipoRegistro`
| estabelecimento | string | `TransactionalMovement::getEstabelecimento`
| data_inicial_transacao | string | `TransactionalMovement::getDataInicialTransacao`
| hora_inicial_transacao | string | `TransactionalMovement::getHoraInicialTransacao`
| data_venda_ajuste | string | `TransactionalMovement::getDataVendaAjuste`
| hora_venda_ajuste | string | `TransactionalMovement::getHoraVendaAjuste`
| tipo_evento | string | `TransactionalMovement::getTipoEvento`
| tipo_transacao | string | `TransactionalMovement::getTipoTransacao`
| codigo_transacao | string | `TransactionalMovement::getCodigoTransacao`
| codigo_venda | string | `TransactionalMovement::getCodigoVenda`
| valor_total_transacao | float | `TransactionalMovement::getValorTotalTransacao`
| valor_parcela | float | `TransactionalMovement::getValorParcela`
| pagamento_prazo | string | `TransactionalMovement::getPagamentoPrazo`
| plano | string | `TransactionalMovement::getPlano`
| parcela | string | `TransactionalMovement::getParcela`
| quantidade_parcela | string | `TransactionalMovement::getQuantidadeParcela`
| data_prevista_pagamento | string | `TransactionalMovement::getDataPrevistaPagamento`
| taxa_parcela_comprador | float | `TransactionalMovement::getTaxaParcelaComprador`
| tarifa_boleto_compra | float | `TransactionalMovement::getTarifaBoletoCompra`
| valor_original_transacao | float | `TransactionalMovement::getValorOriginalTransacao`
| taxa_parcela_vendedor | float | `TransactionalMovement::getTaxaParcelaVendedor`
| taxa_intermediacao | float | `TransactionalMovement::getTaxaIntermediacao`
| tarifa_intermediacao | float | `TransactionalMovement::getTarifaIntermediacao`
| tarifa_boleto_vendedor | float | `TransactionalMovement::getTarifaBoletoVendedor`
| taxa_rep_aplicacao | float | `TransactionalMovement::getTaxaRepAplicacao`
| valor_liquido_transacao | float | `TransactionalMovement::getValorLiquidoTransacao`
| status_pagamento | string | `TransactionalMovement::getStatusPagamento`
| meio_pagamento | string | `TransactionalMovement::getMeioPagamento`
| instituicao_financeira | string | `TransactionalMovement::getInstituicaoFinanceira`
| canal_entrada | string | `TransactionalMovement::getCanalEntrada`
| leitor | string | `TransactionalMovement::getLeitor`
| meio_captura | string | `TransactionalMovement::getMeioCaptura`
| num_logico | string | `TransactionalMovement::getNumLogico`
| nsu | string | `TransactionalMovement::getNsu`
| cartao_bin | string | `TransactionalMovement::getCartaoBin`
| cartao_holder | string | `TransactionalMovement::getCartaoHolder`
| codigo_autorizacao | string | `TransactionalMovement::getCodigoAutorizacao`
| codigo_cv | string | `TransactionalMovement::getCodigoCv`
| numero_serie_leitor | string | `TransactionalMovement::getNumeroSerieLeitor`
| tx_id | string | `TransactionalMovement::getTxId`

### Finantial

| Attribute name | Type | Method
| --- | --- | ---
| movimento_api_codigo | string | `FinantialMovement::getMovimentoApiCodigo`
| tipo_registro | string | `FinantialMovement::getTipoRegistro`
| estabelecimento | string | `FinantialMovement::getEstabelecimento`
| data_inicial_transacao | string | `FinantialMovement::getDataInicialTransacao`
| hora_inicial_transacao | string | `FinantialMovement::getHoraInicialTransacao`
| data_venda_ajuste | string | `FinantialMovement::getDataVendaAjuste`
| hora_venda_ajuste | string | `FinantialMovement::getHoraVendaAjuste`
| tipo_evento | string | `FinantialMovement::getTipoEvento`
| tipo_transacao | string | `FinantialMovement::getTipoTransacao`
| codigo_transacao | string | `FinantialMovement::getCodigoTransacao`
| codigo_venda | string | `FinantialMovement::getCodigoVenda`
| valor_total_transacao | float | `FinantialMovement::getValorTotalTransacao`
| valor_parcela | float | `FinantialMovement::getValorParcela`
| pagamento_prazo | string | `FinantialMovement::getPagamentoPrazo`
| plano | string | `FinantialMovement::getPlano`
| parcela | string | `FinantialMovement::getParcela`
| quantidade_parcela | string | `FinantialMovement::getQuantidadeParcela`
| taxa_parcela_comprador | float | `FinantialMovement::getTaxaParcelaComprador`
| tarifa_boleto_compra | float | `FinantialMovement::getTarifaBoletoCompra`
| valor_original_transacao | float | `FinantialMovement::getValorOriginalTransacao`
| taxa_parcela_vendedor | float | `FinantialMovement::getTaxaParcelaVendedor`
| taxa_intermediacao | float | `FinantialMovement::getTaxaIntermediacao`
| tarifa_intermediacao | float | `FinantialMovement::getTarifaIntermediacao`
| tarifa_boleto_vendedor | float | `FinantialMovement::getTarifaBoletoVendedor`
| taxa_rep_aplicacao | float | `FinantialMovement::getTaxaRepAplicacao`
| valor_liquido_transacao | float | `FinantialMovement::getValorLiquidoTransacao`
| taxa_antecipacao | float | `FinantialMovement::getTaxaAntecipacao`
| valor_liquido_antecipacao | float | `FinantialMovement::getValorLiquidoAntecipacao`
| status_pagamento | string | `FinantialMovement::getStatusPagamento`
| identificador_revenda | string | `FinantialMovement::getIdentificadorRevenda`
| meio_pagamento | string | `FinantialMovement::getMeioPagamento`
| instituicao_financeira | string | `FinantialMovement::getInstituicaoFinanceira`
| canal_entrada | string | `FinantialMovement::getCanalEntrada`
| leitor | string | `FinantialMovement::getLeitor`
| meio_captura | string | `FinantialMovement::getMeioCaptura`
| cod_banco | string | `FinantialMovement::getCodBanco`
| banco_agencia | string | `FinantialMovement::getBancoAgencia`
| conta_banco | string | `FinantialMovement::getContaBanco`
| num_logico | string | `FinantialMovement::getNumLogico`
| nsu | string | `FinantialMovement::getNsu`
| cartao_bin | string | `FinantialMovement::getCartaoBin`
| cartao_holder | string | `FinantialMovement::getCartaoHolder`
| codigo_autorizacao | string | `FinantialMovement::getCodigoAutorizacao`
| codigo_cv | string | `FinantialMovement::getCodigoCv`
| numero_serie_leitor | string | `FinantialMovement::getNumeroSerieLeitor`
| tx_id | string | `FinantialMovement::getTxId`

### Anticipation

Not implemented yet, to be done.