<?php

namespace Kubinyete\Edi\PagSeguro\Core;

use Throwable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Kubinyete\Edi\PagSeguro\Http\Response;
use Kubinyete\Edi\PagSeguro\IO\JsonSerializer;
use Kubinyete\Edi\PagSeguro\Core\Misc\Paginator;
use Kubinyete\Edi\PagSeguro\Exception\HttpException;
use Kubinyete\Edi\PagSeguro\Model\Movement\Pagination;
use Kubinyete\Edi\PagSeguro\Model\Token\TokenResponse;
use Kubinyete\Edi\PagSeguro\Http\Client\GuzzleHttpClient;
use Kubinyete\Edi\PagSeguro\Model\Error\PagSeguroRequestError;
use Kubinyete\Edi\PagSeguro\Model\Movement\TransactionalMovement;
use Kubinyete\Edi\PagSeguro\Core\Misc\TransactionalMovementPaginator;
use Kubinyete\Edi\PagSeguro\Exception\PagSeguro\PagSeguroHttpException;

class PagSeguroEdiClient extends Client
{
    public const VERSION_100 = '1.00';
    public const VERSION_200 = '2.00';
    public const VERSION_201 = '2.01';
    public const VERSION_LATEST = self::VERSION_201;

    public const MOVEMENT_TRANSACTIONAL = 1;
    public const MOVEMENT_FINANTIAL = 2;
    public const MOVEMENT_ANTICIPATION = 3;

    public function __construct(
        PagSeguroEdiEnvironment $env,
        private string $clientId,
        private string $token,
        private string $version = self::VERSION_LATEST,
        ?LoggerInterface $logger = null
    ) {
        parent::__construct(
            $env,
            new GuzzleHttpClient([
                'headers' => [
                    'User-Agent' => 'PagSeguroEdiClient for PHP (kubinyete/pagseguro-edi)'
                ],
            ]),
            new JsonSerializer(),
            $logger
        );
    }

    public function verifyTokenAccess(): TokenResponse
    {
        return TokenResponse::parse($this->get("/users/{$this->clientId}/token/{$this->token}")->getParsed());
    }

    protected function getMovementsPage(DateTimeInterface $date, int $type, int $page, int $pageSize = 100): Response
    {
        return $this->get("/{$this->version}/movimentos", [
            'dataMovimento' => $date->format('Y-m-d'),
            'tipoMovimento' => $type,
            'pageSize' => $pageSize,
            'pageNumber' => $page,
        ], ['Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->token}")]);
    }

    protected function getTransactionalMovementsPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->getMovementsPage($date, self::MOVEMENT_TRANSACTIONAL, $page, $pageSize);
    }

    protected function getFinantialMovementsPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->getMovementsPage($date, self::MOVEMENT_FINANTIAL, $page, $pageSize);
    }

    protected function getAnticipationMovementsPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->getMovementsPage($date, self::MOVEMENT_ANTICIPATION, $page, $pageSize);
    }

    //

    public function getTransactionalMovements(DateTimeInterface $date, int $pageSize = 100): Paginator
    {
        return new Paginator(function (int $page, int $size, callable $limiter) use ($date) {
            $response = $this->getTransactionalMovementsPage($date, $page, $size);
            $pagination = Pagination::parse($response->getParsedPath('pagination'));
            dump($pagination->jsonSerialize());
            $limiter($pagination->getTotalPages());

            return array_map(fn ($x) => TransactionalMovement::parse($x), $response->getParsedPath('detalhes'));
        }, 1, $pageSize);
    }
}
